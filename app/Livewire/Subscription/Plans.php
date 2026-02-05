<?php

namespace App\Livewire\Subscription;

use Livewire\Component;

class Plans extends Component
{
    public string $billingCycle = 'monthly';

    public function subscribe(string $plan)
    {
        $user = auth()->user();
        
        $priceId = $this->billingCycle === 'monthly'
            ? config("services.stripe.price_{$plan}_monthly")
            : config("services.stripe.price_{$plan}_yearly");

        if (!$priceId) {
            session()->flash('error', 'Prix non configuré');
            return;
        }

        $checkout = $user->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscription.plans'),
            ]);

        return $this->redirect($checkout->url, navigate: false);
    }

    public function redirectToPortal()
    {
        $url = auth()->user()->billingPortalUrl(route('subscription.plans'));
        return $this->redirect($url, navigate: false);
    }

    public function render()
    {
        $user = auth()->user();

        $plans = [
            'free' => [
                'name' => 'Free',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'features' => [
                    '1 profil',
                    'Code 8 caractères aléatoire',
                    '2 liens sociaux',
                    '2 images (sans liens)',
                    '1 bloc texte',
                ],
            ],
            'pro' => [
                'name' => 'Pro',
                'price_monthly' => 5,
                'price_yearly' => 50,
                'features' => [
                    '1 profil (+5$/mois par extra)',
                    'Username personnalisé',
                    '5 liens sociaux',
                    '5 images avec liens',
                    '2 blocs texte',
                    'QR Code popup',
                ],
            ],
            'premium' => [
                'name' => 'Premium',
                'price_monthly' => 8,
                'price_yearly' => 80,
                'features' => [
                    '1 profil (+8$/mois par extra)',
                    'Username personnalisé obligatoire',
                    '10 liens sociaux',
                    '10 images avec liens',
                    '5 blocs texte',
                    'QR Code popup',
                ],
            ],
        ];

        return view('livewire.subscription.plans', [
            'plans' => $plans,
            'currentPlan' => $user->plan ?? 'free',
        ])->layout('layouts.dashboard');
    }
}
