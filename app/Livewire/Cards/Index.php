<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\Card;

class Index extends Component
{
    public function toggleActive(Card $card)
    {
        // Vérifier que la carte appartient à l'user
        if ($card->user_id !== auth()->id()) {
            abort(403);
        }

        $card->update(['is_active' => !$card->is_active]);

        $this->dispatch('card-updated');
    }

    public function updateProfile(Card $card, $profileId)
    {
        if ($card->user_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier que le profil appartient à l'user
        $profile = auth()->user()->profiles()->findOrFail($profileId);

        $card->update(['profile_id' => $profile->id]);

        $this->dispatch('card-updated');
    }

    public function render()
    {
        $user = auth()->user();
        $cards = $user->cards()->with('profile')->latest()->get();
        $profiles = $user->profiles;

        $stats = [
            'total' => $cards->count(),
            'active' => $cards->where('is_active', true)->count(),
            'totalScans' => $cards->sum('scan_count'),
        ];

        return view('livewire.cards.index', compact('cards', 'profiles', 'stats'))
            ->layout('layouts.dashboard', ['title' => 'Mes Cartes']);
    }
}
