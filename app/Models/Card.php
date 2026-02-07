<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Card extends Model
{
    protected $fillable = [
        'card_code',
        'user_id',
        'profile_id',
        'is_active',
        'order_id',
        'programmed_at',
        'shipped_at',
        'activated_at',
        'scan_count',
        'last_scanned_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'programmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'activated_at' => 'datetime',
        'last_scanned_at' => 'datetime',
    ];

    // Charset sans caractères ambigus (pas 0/O, 1/l/I)
    const CODE_CHARSET = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= self::CODE_CHARSET[random_int(0, strlen(self::CODE_CHARSET) - 1)];
            }
        } while (self::where('card_code', $code)->exists());

        return $code;
    }

    public function isLinked(): bool
    {
        return $this->profile_id !== null;
    }

    public function isPendingActivation(): bool
    {
        return $this->user_id === null && $this->activated_at === null;
    }

    public function recordScan(): void
    {
        $this->increment('scan_count');
        $this->update(['last_scanned_at' => now()]);
    }
}
