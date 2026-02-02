<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ImageBand;
use App\Models\ContentBand;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'full_name',
        'job_title',
        'company',
        'location',
        'bio',
        'email',
        'phone',
        'website',
        'photo_path',
        'template_id',
        'primary_color',
        'secondary_color',
        'background_type',
        'background_value',
        'is_public',
        'view_count',
        'qr_code',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'view_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class)->orderBy('order');
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class)->orderBy('order');
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function contentBands(): HasMany
    {
        return $this->hasMany(ContentBand::class)->orderBy('order');
    }

    public function imageBands(): HasMany
    {
        return $this->hasMany(ImageBand::class)->orderBy('order');
    }
}
