<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'scan_count' => 'integer',
    ];

    /**
     * Charset sans caractères ambigus (0/O, 1/l/I)
     */
    private static string $charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Générer un code unique de 8 caractères
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= static::$charset[random_int(0, strlen(static::$charset) - 1)];
            }
        } while (static::where('card_code', $code)->exists());

        return $code;
    }

    /**
     * Vérifier si la carte est assignée à un profil et activée
     */
    public function isLinked(): bool
    {
        return $this->is_active && $this->profile_id !== null && $this->activated_at !== null;
    }

    /**
     * Vérifier si la carte est en attente d'activation
     */
    public function isPendingActivation(): bool
    {
        return $this->user_id !== null && $this->activated_at === null;
    }

    /**
     * Incrémenter le compteur de scans
     */
    public function recordScan(): void
    {
        $this->increment('scan_count');
        $this->update(['last_scanned_at' => now()]);
    }

    // Relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
