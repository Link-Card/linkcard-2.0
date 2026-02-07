<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'source',
        'rewarded',
    ];

    protected function casts(): array
    {
        return [
            'rewarded' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
