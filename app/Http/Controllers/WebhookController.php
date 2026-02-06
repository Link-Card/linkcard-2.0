<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PlanLimitsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleCheckoutSessionCompleted(array $payload)
    {
        Log::info('=== WEBHOOK: checkout.session.completed ===', [
            'customer' => $payload['data']['object']['customer'] ?? 'unknown'
        ]);
        
        return parent::handleCheckoutSessionCompleted($payload);
    }

    public function handleCustomerSubscriptionCreated(array $payload)
    {
        Log::info('=== WEBHOOK START: subscription.created ===');
        
        // Appeler le parent EN PREMIER
        $response = parent::handleCustomerSubscriptionCreated($payload);
        
        // ENSUITE mettre à jour le plan
        $user = $this->updateUserPlan($payload);
        
        if ($user) {
            PlanLimitsService::unhideOnUpgrade($user);
        }
        
        Log::info('=== WEBHOOK END: subscription.created ===');
        
        return $response;
    }

    public function handleCustomerSubscriptionUpdated(array $payload)
    {
        Log::info('=== WEBHOOK START: subscription.updated ===');
        
        $stripeCustomerId = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', $stripeCustomerId)->first();
        $oldPlan = $user?->plan;
        
        // Appeler le parent EN PREMIER
        $response = parent::handleCustomerSubscriptionUpdated($payload);
        
        // ENSUITE mettre à jour le plan
        $user = $this->updateUserPlan($payload);
        
        if ($user && $oldPlan) {
            $planOrder = ['free' => 0, 'pro' => 1, 'premium' => 2];
            $oldLevel = $planOrder[$oldPlan] ?? 0;
            $newLevel = $planOrder[$user->plan] ?? 0;
            
            if ($newLevel > $oldLevel) {
                PlanLimitsService::unhideOnUpgrade($user);
            } elseif ($newLevel < $oldLevel) {
                PlanLimitsService::applyLimitsOnDowngrade($user);
            }
        }
        
        Log::info('=== WEBHOOK END: subscription.updated ===');
        
        return $response;
    }

    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        Log::info('=== WEBHOOK START: subscription.deleted ===');
        
        // Appeler le parent EN PREMIER
        $response = parent::handleCustomerSubscriptionDeleted($payload);
        
        // ENSUITE mettre à jour le plan
        $stripeCustomerId = $payload['data']['object']['customer'];
        $user = User::where('stripe_id', $stripeCustomerId)->first();
        
        if ($user) {
            DB::table('users')->where('id', $user->id)->update(['plan' => 'free']);
            Log::info('Webhook: User downgraded to free', ['user_id' => $user->id]);
            
            $user->refresh();
            PlanLimitsService::applyLimitsOnDowngrade($user);
        }
        
        Log::info('=== WEBHOOK END: subscription.deleted ===');
        
        return $response;
    }
    
    public function handleInvoicePaymentSucceeded(array $payload)
    {
        Log::info('=== WEBHOOK: invoice.payment_succeeded ===', [
            'customer' => $payload['data']['object']['customer'] ?? 'unknown'
        ]);
        
        return parent::handleInvoicePaymentSucceeded($payload);
    }

    protected function updateUserPlan(array $payload): ?User
    {
        $stripeCustomerId = $payload['data']['object']['customer'];
        $priceId = $payload['data']['object']['items']['data'][0]['price']['id'] ?? null;
        
        Log::info('Webhook: Looking for user', ['stripe_id' => $stripeCustomerId]);
        
        $user = User::where('stripe_id', $stripeCustomerId)->first();
        
        if (!$user) {
            Log::warning('Webhook: User NOT FOUND', ['stripe_id' => $stripeCustomerId]);
            return null;
        }
        
        Log::info('Webhook: User found', ['user_id' => $user->id, 'current_plan' => $user->plan]);
        
        if (!$priceId) {
            Log::warning('Webhook: No price_id in payload');
            return $user;
        }
        
        // Determine plan
        $proPrices = [
            config('services.stripe.price_pro_monthly'),
            config('services.stripe.price_pro_yearly')
        ];
        $premiumPrices = [
            config('services.stripe.price_premium_monthly'),
            config('services.stripe.price_premium_yearly')
        ];
        
        if (in_array($priceId, $premiumPrices)) {
            $newPlan = 'premium';
        } elseif (in_array($priceId, $proPrices)) {
            $newPlan = 'pro';
        } else {
            $newPlan = 'free';
        }
        
        Log::info('Webhook: Updating plan', ['new_plan' => $newPlan]);
        
        // Update via DB::table
        DB::table('users')->where('id', $user->id)->update(['plan' => $newPlan]);
        
        // Vérifier
        $dbPlan = DB::table('users')->where('id', $user->id)->value('plan');
        Log::info('Webhook: Plan updated', ['db_plan' => $dbPlan]);
        
        $user->refresh();
        
        return $user;
    }
}
