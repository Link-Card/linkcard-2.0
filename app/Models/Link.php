<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    protected $fillable = [
        'profile_id',
        'platform',
        'url',
        'label',
        'order',
        'click_count',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    // Icônes par plateforme
    public static function getPlatformIcon($platform): string
    {
        $icons = [
            'facebook' => '📘',
            'instagram' => '📷',
            'linkedin' => '💼',
            'twitter' => '🐦',
            'tiktok' => '🎵',
            'youtube' => '📺',
            'github' => '💻',
            'website' => '🌐',
            'email' => '✉️',
            'phone' => '📞',
            'other' => '🔗',
        ];

        return $icons[$platform] ?? $icons['other'];
    }
}
