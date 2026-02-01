<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BandImage extends Model
{
    protected $fillable = [
        'band_id',
        'image_path',
        'link',
        'align',
        'spacing_px',
        'text',
        'custom_height',
        'height_px',
        'order'
    ];

    protected $casts = [
        'custom_height' => 'boolean'
    ];

    public function band(): BelongsTo
    {
        return $this->belongsTo(ImageBand::class);
    }
}
