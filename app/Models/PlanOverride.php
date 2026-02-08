<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanOverride extends Model
{
    protected $fillable = [
        'user_id',
        'granted_plan',
        'previous_plan',
        'granted_by',
        'reason',
        'note',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' 
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isPermanent(): bool
    {
        return $this->expires_at === null;
    }

    public function daysRemaining(): ?int
    {
        if ($this->isPermanent()) return null;
        if ($this->isExpired()) return 0;
        return (int) now()->diffInDays($this->expires_at, false);
    }

    public function reasonLabel(): string
    {
        return match($this->reason) {
            'beta' => 'Beta testeur',
            'support' => 'Support client',
            'promo' => 'Promotion',
            'gift' => 'Cadeau',
            'testing' => 'Test admin',
            default => $this->reason,
        };
    }

    /**
     * Expire this override and revert user's plan
     */
    public function expire(): void
    {
        $this->update(['status' => 'expired']);

        $user = $this->user;

        // Check if user has active Stripe subscription
        if ($user->subscribed('default')) {
            // Revert to Stripe plan
            $subscription = $user->subscription('default');
            $stripePrice = $subscription->stripe_price;

            $stripePlan = 'free';
            $proPrices = [
                config('services.stripe.prices.pro_monthly'),
                config('services.stripe.prices.pro_yearly'),
            ];
            $premiumPrices = [
                config('services.stripe.prices.premium_monthly'),
                config('services.stripe.prices.premium_yearly'),
            ];

            if (in_array($stripePrice, $proPrices)) {
                $stripePlan = 'pro';
            } elseif (in_array($stripePrice, $premiumPrices)) {
                $stripePlan = 'premium';
            }

            $user->update(['plan' => $stripePlan]);
        } else {
            // No Stripe → revert to free
            $user->update(['plan' => 'free']);
        }

        // Apply limits for the new (lower) plan
        \App\Services\PlanLimitsService::applyLimitsOnDowngrade($user);

        \Illuminate\Support\Facades\Log::info('Plan override expired', [
            'user_id' => $user->id,
            'override_id' => $this->id,
            'was_plan' => $this->granted_plan,
            'reverted_to' => $user->fresh()->plan,
        ]);
    }
}
