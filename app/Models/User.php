<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'plan',
        'role',
        'verification_code',
        'verification_code_expires_at',
        'welcome_email_sent_at',
        'referral_code',
        'referred_by',
        'premium_bonus_months',
        'premium_bonus_used',
        'notify_connection_request',
        'notify_connection_accepted',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'welcome_email_sent_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function cardOrders()
    {
        return $this->hasMany(CardOrder::class);
    }

    public function planOverrides()
    {
        return $this->hasMany(PlanOverride::class);
    }

    public function activePlanOverride()
    {
        return $this->hasOne(PlanOverride::class)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest();
    }

    public function impersonationRequests()
    {
        return $this->hasMany(ImpersonationRequest::class, 'user_id');
    }

    public function pendingImpersonationRequest()
    {
        return $this->hasOne(ImpersonationRequest::class, 'user_id')
            ->where('status', 'pending')
            ->latest();
    }

    // --- Connexions ---

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    /**
     * Toutes les connexions acceptées (envoyées + reçues).
     */
    public function acceptedConnections()
    {
        return Connection::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('sender_id', $this->id)
                  ->orWhere('receiver_id', $this->id);
            });
    }

    /**
     * Demandes de connexion reçues en attente.
     */
    public function pendingReceivedConnections()
    {
        return $this->receivedConnections()->where('status', 'pending');
    }

    /**
     * Nombre de demandes en attente (pour badge sidebar).
     */
    public function getPendingConnectionsCountAttribute(): int
    {
        return $this->pendingReceivedConnections()->count();
    }

    // --- Referrals ---

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    // --- Auth helpers ---

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
}
