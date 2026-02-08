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
        'username_changed_at',
        'previous_custom_username',
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
        'username_changed_at' => 'datetime',
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

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function usernameRedirects()
    {
        return $this->hasMany(UsernameRedirect::class);
    }

    public function profileViews()
    {
        return $this->hasMany(ProfileView::class);
    }

    public function linkClicks()
    {
        return $this->hasMany(LinkClick::class);
    }

    /**
     * Vérifie si le user peut changer son username selon son plan.
     */
    public function canChangeUsername(): array
    {
        $user = $this->user;
        $plan = $user->plan ?? 'free';

        if ($plan === 'free') {
            return ['allowed' => false, 'reason' => 'Disponible avec le forfait PRO ou PREMIUM.'];
        }

        if (!$this->username_changed_at) {
            return ['allowed' => true, 'reason' => null];
        }

        $months = $plan === 'premium' ? 3 : 12; // Premium: 1x/3mois, Pro: 1x/an
        $nextChange = $this->username_changed_at->addMonths($months);

        if (now()->lt($nextChange)) {
            return [
                'allowed' => false,
                'reason' => 'Prochain changement possible le ' . $nextChange->format('d/m/Y') . '.',
            ];
        }

        return ['allowed' => true, 'reason' => null];
    }
}
