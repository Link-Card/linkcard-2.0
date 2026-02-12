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
        'template_config',
        'primary_color',
        'secondary_color',
        'text_color',
        'button_color',
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
        'template_config' => 'array',
    ];

    /**
     * Get the template definition from TemplateService.
     */
    public function getTemplateAttribute(): ?array
    {
        return \App\Services\TemplateService::get($this->template_id ?? 'classic');
    }

    /**
     * Get effective template config (merges template defaults with custom overrides).
     * Used by Custom template (#13) where user can override header_style, etc.
     */
    public function getEffectiveTemplateConfig(): array
    {
        $template = $this->template;
        if (!$template) {
            $template = \App\Services\TemplateService::get('classic');
        }

        // For custom template, merge user overrides
        if ($this->template_id === 'custom' && $this->template_config) {
            return array_merge($template, $this->template_config);
        }

        return $template;
    }

    /**
     * Get the header style to use for rendering.
     */
    public function getHeaderStyle(): string
    {
        $config = $this->getEffectiveTemplateConfig();
        return $config['header_style'] ?? 'classic';
    }

    /**
     * Get the transition style to use for rendering.
     */
    public function getTransition(): string
    {
        $config = $this->getEffectiveTemplateConfig();
        return $config['transition'] ?? 'wave';
    }

    /**
     * Get the social display style to use for rendering.
     */
    public function getSocialStyle(): string
    {
        $config = $this->getEffectiveTemplateConfig();
        return $config['social_style'] ?? 'pills';
    }

    /**
     * Get the photo style to use for rendering.
     */
    public function getPhotoStyle(): string
    {
        $config = $this->getEffectiveTemplateConfig();
        return $config['photo_style'] ?? 'round_center';
    }

    /**
     * Get the button style to use for rendering.
     */
    public function getButtonStyle(): string
    {
        $config = $this->getEffectiveTemplateConfig();
        return $config['button_style'] ?? 'rounded';
    }

    /**
     * Check if this profile's template supports a specific feature.
     */
    public function templateHasFeature(string $feature): bool
    {
        $config = $this->getEffectiveTemplateConfig();
        return in_array($feature, $config['features'] ?? []);
    }

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

    /**
     * Format phone number with dashes (819-244-6640).
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->phone) return null;

        $digits = preg_replace('/\D/', '', $this->phone);

        // 10 digits: XXX-XXX-XXXX
        if (strlen($digits) === 10) {
            return substr($digits, 0, 3) . '-' . substr($digits, 3, 3) . '-' . substr($digits, 6);
        }

        // 11 digits (1XXXXXXXXXX): 1-XXX-XXX-XXXX
        if (strlen($digits) === 11 && $digits[0] === '1') {
            return '1-' . substr($digits, 1, 3) . '-' . substr($digits, 4, 3) . '-' . substr($digits, 7);
        }

        // Other formats: return as-is
        return $this->phone;
    }
}
