<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentBand extends Model
{
    protected $fillable = [
        'profile_id',
        'type',
        'order',
        'data',
        'settings'
    ];

    protected $casts = [
        'data' => 'array',
        'settings' => 'array'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    // Helper methods pour chaque type
    public function isSocialLink(): bool
    {
        return $this->type === 'social_link';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isContactButton(): bool
    {
        return $this->type === 'contact_button';
    }

    public function isTextBlock(): bool
    {
        return $this->type === 'text_block';
    }
}
