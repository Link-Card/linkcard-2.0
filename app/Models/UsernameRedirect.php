<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsernameRedirect extends Model
{
    protected $fillable = ['old_username', 'profile_id', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function isActive(): bool
    {
        return $this->expires_at->isFuture();
    }
}
