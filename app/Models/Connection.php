<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
        ];
    }

    // --- Relations ---

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // --- Scopes ---

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Retourne l'autre user dans la connexion.
     */
    public function getOtherUser(int $userId): ?User
    {
        if ($this->sender_id === $userId) {
            return $this->receiver;
        }
        if ($this->receiver_id === $userId) {
            return $this->sender;
        }
        return null;
    }
}
