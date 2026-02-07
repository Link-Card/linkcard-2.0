<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Redirect NFC card scan to linked profile
     * GET /c/{cardCode}
     */
    public function redirect(string $cardCode)
    {
        $card = Card::where('card_code', strtoupper($cardCode))->first();

        // Carte inexistante
        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        // Carte pas encore assignée à un user → page activation
        if (!$card->user_id) {
            return redirect()->route('card.activate.show', $card->card_code);
        }

        // Carte désactivée
        if (!$card->is_active) {
            return response()->view('cards.inactive', [], 403);
        }

        // Carte sans profil lié
        if (!$card->profile_id) {
            return response()->view('cards.no-profile', ['card' => $card], 404);
        }

        // Enregistrer le scan
        $card->recordScan();

        // Incrémenter aussi le view_count du profil
        $card->profile->incrementViewCount();

        // Redirect vers le profil public
        return redirect()->route('profile.public', $card->profile->username);
    }

    /**
     * Page d'activation de carte
     * GET /c/{cardCode}/activate
     */
    public function showActivation(string $cardCode)
    {
        $card = Card::where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        // Déjà activée → redirect vers profil
        if ($card->activated_at) {
            return redirect()->route('card.redirect', $card->card_code);
        }

        return view('cards.activate', ['card' => $card]);
    }

    /**
     * Activer une carte (lier à son compte + profil)
     * POST /c/{cardCode}/activate
     */
    public function activate(Request $request, string $cardCode)
    {
        $card = Card::where('card_code', strtoupper($cardCode))->first();

        if (!$card) {
            return response()->view('cards.not-found', [], 404);
        }

        if ($card->activated_at) {
            return redirect()->route('card.redirect', $card->card_code)
                ->with('info', 'Cette carte est déjà activée.');
        }

        $user = $request->user();

        if (!$user) {
            // Stocker le code carte en session pour après login
            session(['pending_card_activation' => $card->card_code]);
            return redirect()->route('login')
                ->with('info', 'Connectez-vous pour activer votre carte.');
        }

        $request->validate([
            'profile_id' => 'required|exists:profiles,id',
        ]);

        // Vérifier que le profil appartient à l'user
        $profile = $user->profiles()->findOrFail($request->profile_id);

        $card->update([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'activated_at' => now(),
        ]);

        return redirect()->route('card.redirect', $card->card_code)
            ->with('success', 'Carte activée avec succès!');
    }
}
