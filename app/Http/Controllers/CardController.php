<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CardOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CardActivated;

class CardController extends Controller
{
    /**
     * Main NFC scan handler
     * GET /c/{cardCode}
     */
    public function redirect($cardCode)
    {
        $card = Card::with('profile', 'user')->where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if (!$card->is_active) {
            return response()->view('cards.inactive', [], 403);
        }

        // Card not assigned to any user → old activation flow
        if (!$card->user_id) {
            return redirect()->route('card.activate.show', $card->card_code);
        }

        // Card assigned but NOT yet confirmed (first scan) → confirmation page
        if (!$card->activated_at) {
            return redirect()->route('card.confirm.show', $card->card_code);
        }

        // Card active + confirmed → no profile linked
        if (!$card->profile_id || !$card->profile) {
            return response()->view('cards.no-profile', ['card' => $card], 200);
        }

        // Normal scan → record + redirect to profile
        $card->recordScan();

        return redirect()->route('profile.public', $card->profile->username);
    }

    /**
     * Show confirmation page (first scan after receiving card)
     * GET /c/{cardCode}/confirm
     */
    public function showConfirmation($cardCode)
    {
        $card = Card::with('profile', 'user')->where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        // Already activated → redirect normal
        if ($card->activated_at) {
            return redirect()->route('card.redirect', $card->card_code);
        }

        return view('cards.confirm-reception', ['card' => $card]);
    }

    /**
     * Confirm card reception (first scan)
     * POST /c/{cardCode}/confirm
     */
    public function confirmReception(Request $request, $cardCode)
    {
        $card = Card::with('profile', 'user')->where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if ($card->activated_at) {
            return redirect()->route('card.redirect', $card->card_code);
        }

        // Must be logged in as the card owner
        if (!auth()->check() || auth()->id() !== $card->user_id) {
            session(['pending_card_confirm' => $card->card_code]);
            return redirect()->route('login')
                ->with('info', 'Connectez-vous pour confirmer la réception de votre carte.');
        }

        // Activate the card
        $card->update(['activated_at' => now()]);
        $card->recordScan();

        // Mark related order as delivered
        if ($card->order_id) {
            $order = CardOrder::find($card->order_id);
            if ($order && $order->status === 'shipped') {
                $order->update(['status' => 'delivered']);
            }
        }

        // Send activation email
        try {
            Mail::to($card->user->email)->send(new CardActivated($card->fresh(['user', 'profile'])));
        } catch (\Exception $e) {
            Log::error('Card activation email failed', ['error' => $e->getMessage()]);
        }

        // Redirect to profile
        if ($card->profile) {
            return redirect()->route('profile.public', $card->profile->username)
                ->with('success', 'Carte activée avec succès!');
        }

        return redirect()->route('cards.index')->with('success', 'Carte activée avec succès!');
    }

    /**
     * Show activation page (for unassigned cards)
     * GET /c/{cardCode}/activate
     */
    public function showActivation($cardCode)
    {
        $card = Card::where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if ($card->activated_at) {
            return redirect()->route('card.redirect', $card->card_code);
        }

        return view('cards.activate', ['card' => $card]);
    }

    /**
     * Activate unassigned card (assign to user + profile)
     * POST /c/{cardCode}/activate
     */
    public function activate(Request $request, $cardCode)
    {
        $card = Card::where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
        ]);

        $profile = auth()->user()->profiles()->findOrFail($request->profile_id);

        $card->update([
            'user_id' => auth()->id(),
            'profile_id' => $profile->id,
            'activated_at' => now(),
        ]);

        // Send activation email
        try {
            Mail::to(auth()->user()->email)->send(new CardActivated($card->fresh(['user', 'profile'])));
        } catch (\Exception $e) {
            Log::error('Card activation email failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('cards.index')->with('success', 'Carte activée avec succès!');
    }
}
