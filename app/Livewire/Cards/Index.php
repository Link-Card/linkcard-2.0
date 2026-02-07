<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\Card;

class Index extends Component
{
    public function toggleActive($cardId)
    {
        $card = auth()->user()->cards()->findOrFail($cardId);
        $card->update(['is_active' => !$card->is_active]);
    }

    public function updateProfile($cardId, $profileId)
    {
        $card = auth()->user()->cards()->findOrFail($cardId);

        if ($profileId) {
            auth()->user()->profiles()->findOrFail($profileId);
        }

        $card->update(['profile_id' => $profileId ?: null]);
    }

    public function render()
    {
        $cards = auth()->user()->cards()->with('profile')->get();

        return view('livewire.cards.index', [
            'cards' => $cards,
            'profiles' => auth()->user()->profiles,
            'totalCards' => $cards->count(),
            'activeCards' => $cards->where('is_active', true)->count(),
            'totalScans' => $cards->sum('scan_count'),
        ])->layout('layouts.dashboard');
    }
}
