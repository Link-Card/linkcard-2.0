<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpersonationRequest extends Model
{
    protected $fillable = [
        'admin_id',
        'user_id',
        'reason',
        'status',
        'approved_at',
        'expires_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'approved'
            && $this->expires_at !== null
            && $this->expires_at->isFuture();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
