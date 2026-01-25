<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Stats utilisateur
        $stats = [
            'plan' => $user->subscription_plan,
            'profiles' => 0, // À implémenter plus tard
            'cards' => 0,    // À implémenter plus tard
            'views' => 0,    // À implémenter plus tard
        ];
        
        return view('livewire.dashboard.home', compact('stats'))
            ->layout('layouts.dashboard');
    }
}
