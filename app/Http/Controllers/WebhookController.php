<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        $this->updateUserPlan($payload);
        
        return parent::handleCustomerSubscriptionCreated($payload);
    }

    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        $this->updateUserPlan($payload);
        
        return parent::handleCustomerSubscriptionUpdated($payload);
    }

    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        $stripeCustomerId = $payload['data']['object']['customer'];
        
        $user = User::where('stripe_id', $stripeCustomerId)->first();
        
        if ($user) {
            $user->update(['plan' => 'free']);
        }
        
        return parent::handleCustomerSubscriptionDeleted($payload);
    }

    protected function updateUserPlan(array $payload)
    {
        $stripeCustomerId = $payload['data']['object']['customer'];
        $priceId = $payload['data']['object']['items']['data'][0]['price']['id'] ?? null;
        
        $user = User::where('stripe_id', $stripeCustomerId)->first();
        
        if ($user && $priceId) {
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
