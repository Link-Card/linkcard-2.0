<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CardActivated;

class CardController extends Controller
{
    /**
     * Main NFC scan handler - redirect to linked profile
     */
    public function redirect($cardCode)
    {
        $card = Card::where('card_code', $cardCode)->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if (!$card->is_active) {
            return response()->view('cards.inactive', [], 403);
        }

        // Card not yet activated (no user assigned)
        if (!$card->user_id) {
            return redirect()->route('card.activate.show', $cardCode);
        }

        // Card active but no profile linked
        if (!$card->profile_id || !$card->profile) {
            return response()->view('cards.no-profile', ['card' => $card], 200);
        }

        // Record scan and redirect
        $card->recordScan();

        return redirect()->route('profile.public', $card->profile->username);
    }

    /**
     * Show activation page
     */
    public function showActivation($cardCode)
    {
        $card = Card::where('card_code', $cardCode)->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if ($card->activated_at) {
            return redirect()->route('card.redirect', $cardCode);
        }

        $profiles = auth()->check() ? auth()->user()->profiles : collect();

        return view('cards.activate', [
            'card' => $card,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Activate card (assign to user + profile)
     */
    public function activate(Request $request, $cardCode)
    {
        $card = Card::where('card_code', $cardCode)->first();

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
            \Illuminate\Support\Facades\Log::error('Card activation email failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('cards.index')->with('success', 'Carte activée avec succès !');
    }
}
