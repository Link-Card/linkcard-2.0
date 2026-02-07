<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardOrder extends Model
{
    protected $fillable = [
        'user_id',
        'quantity',
        'design_type',
        'logo_path',
        'stripe_payment_id',
        'stripe_session_id',
        'status',
        'shipping_address',
        'tracking_number',
        'amount_cents',
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountDollarsAttribute(): string
    {
        return number_format($this->amount_cents / 100, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente de paiement',
            'paid' => 'Payée',
            'processing' => 'En traitement',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => '#F59E0B',
            'paid' => '#4A7FBF',
            'processing' => '#4A7FBF',
            'shipped' => '#42B574',
            'delivered' => '#42B574',
            default => '#9CA3AF',
        };
    }

    public static function getPriceForUser(User $user): int
    {
        return match($user->plan) {
            'pro' => 4499,     // 44.99$
            'premium' => 3749, // 37.49$
            default => 4999,   // 49.99$
        };
    }

    public static function getDisplayPriceForUser(User $user): string
    {
        return match($user->plan) {
            'pro' => '44.99',
            'premium' => '37.49',
            default => '49.99',
        };
    }
}
