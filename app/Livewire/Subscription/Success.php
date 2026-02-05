<?php

namespace App\Livewire\Subscription;

use Livewire\Component;
use Laravel\Cashier\Cashier;

class Success extends Component
{
    public function mount()
    {
        $sessionId = request()->get('session_id');
        
        if ($sessionId) {
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
            
            if ($session && $session->payment_status === 'paid') {
                $user = auth()->user();
                
                // Déterminer le plan basé sur le price_id
                $priceId = $session->line_items->data[0]->price->id ?? null;
                
                $plan = match($priceId) {
                    config('services.stripe.price_pro_monthly'),
                    config('services.stripe.price_pro_yearly') => 'pro',
                    config('services.stripe.price_premium_monthly'),
                    config('services.stripe.price_premium_yearly') => 'premium',
                    default => 'free'
                };
                
                $user->update(['plan' => $plan]);
            }
        }
    }

    public function render()
    {
        return view('livewire.subscription.success')
            ->layout('layouts.dashboard');
    }
}
