<?php

namespace App\Livewire\Subscription;

use Livewire\Component;

class Success extends Component
{
    public $planName = '';

    public function mount()
    {
        // Le webhook a déjà mis à jour le plan
        // On attend juste un peu pour s'assurer que le webhook est traité
        sleep(2);
        
        $user = auth()->user();
        $user->refresh();
        
        $this->planName = match($user->plan) {
            'pro' => 'Pro',
            'premium' => 'Premium',
            default => 'Gratuit'
        };
    }

    public function render()
    {
        return view('livewire.subscription.success')
            ->layout('layouts.dashboard');
    }
}
