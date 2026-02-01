<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImageBand extends Model
{
    protected $fillable = [
        'profile_id',
        'band_number',
        'order'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BandImage::class, 'band_id')->orderBy('order');
    }
}
