<?php

namespace App\Services;

class TemplateService
{
    /**
     * All template definitions.
     * Each template defines its visual config and plan requirements.
     * 
     * Body theme properties (V2):
     *   body_bg      - Background color of the entire profile body
     *   body_text    - Main text color
     *   card_bg      - Background of sections/cards
     *   card_border  - Border color of cards
     *   card_shadow  - Shadow style: none, sm, md, glow
     *   footer_border - Footer separator color
     *   footer_text  - Footer text color
     *   dark_mode    - Whether the body is dark (affects fallback text colors)
     */
    public static function all(): array
    {
        return [
            // ─── TOUS (Free+) ───
            'classic' => [
                'id' => 1,
                'slug' => 'classic',
                'name' => 'Classique',
                'description' => 'Coupe droite, sobriété pro',
                'category' => 'general',
                'required_plan' => 'free',
                'header_style' => 'classic',
                'transition' => 'none',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
                // Body theme
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'wave' => [
                'id' => 2,
                'slug' => 'wave',
                'name' => 'Vague',
                'description' => '4 vagues parallax animées',
                'category' => 'general',
                'required_plan' => 'free',
                'header_style' => 'wave',
                'transition' => 'double_wave',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'minimal' => [
                'id' => 3,
                'slug' => 'minimal',
                'name' => 'Épuré',
                'description' => 'Barre accent, fond blanc, bouton discret',
                'category' => 'general',
                'required_plan' => 'free',
                'header_style' => 'minimal',
                'transition' => 'none',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'button_style' => 'outline_compact',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'none',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],

            // ─── PRO+ ───
            'diagonal' => [
                'id' => 4,
                'slug' => 'diagonal',
                'name' => 'Élan',
                'description' => 'Coupe en angle dynamique',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'diagonal',
                'transition' => 'diagonal',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#3182CE', 'secondary' => '#1A365D'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'arch' => [
                'id' => 5,
                'slug' => 'arch',
                'name' => 'Arche',
                'description' => 'Courbe élégante + cercles flottants',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'arch',
                'transition' => 'arch',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#805AD5', 'secondary' => '#322659'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'split' => [
                'id' => 6,
                'slug' => 'split',
                'name' => 'Duo',
                'description' => 'Photo à gauche, infos à droite',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'split',
                'transition' => 'wave',
                'photo_style' => 'round_left',
                'social_style' => 'pills',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#E53E3E', 'secondary' => '#742A2A'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'banner' => [
                'id' => 7,
                'slug' => 'banner',
                'name' => 'Vitrine',
                'description' => 'Bannière + photo qui déborde',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'banner',
                'transition' => 'none',
                'photo_style' => 'round_overlap',
                'social_style' => 'circles',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#DD6B20', 'secondary' => '#652B19'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'neon' => [
                'id' => 14,
                'slug' => 'neon',
                'name' => 'Néon',
                'description' => 'Fond sombre, effet lumineux néon',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'neon',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'button_style' => 'rounded',
                'features' => [],
                'default_colors' => ['primary' => '#00D4FF', 'secondary' => '#0066FF'],
                // Dark body theme — the neon magic
                'body_bg' => '#0F0F1A',
                'body_text' => '#E0E0E0',
                'card_bg' => '#1A1A2E',
                'card_border' => 'PRIMARY20',  // Will be replaced with primary color at 20% opacity
                'card_shadow' => 'glow',
                'footer_border' => '#1A1A2E',
                'footer_text' => '#6B7280',
                'dark_mode' => true,
            ],

            // ─── PREMIUM ───
            'geometric' => [
                'id' => 8,
                'slug' => 'geometric',
                'name' => 'Prisme',
                'description' => 'Formes abstraites + chevron',
                'category' => 'general',
                'required_plan' => 'premium',
                'header_style' => 'geometric',
                'transition' => 'chevron',
                'photo_style' => 'square_center',
                'social_style' => 'list',
                'button_style' => 'square',
                'features' => [],
                'default_colors' => ['primary' => '#38B2AC', 'secondary' => '#1D4044'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'bold' => [
                'id' => 9,
                'slug' => 'bold',
                'name' => 'Contraste',
                'description' => 'Header sombre + fond gris + accent couleur',
                'category' => 'general',
                'required_plan' => 'premium',
                'header_style' => 'bold',
                'transition' => 'none',
                'photo_style' => 'round_center',
                'social_style' => 'list',
                'button_style' => 'square',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
                'body_bg' => '#E8E6E3',
                'body_text' => '#2C2A27',
                'card_bg' => '#DFDDD9',
                'card_border' => 'PRIMARY50',
                'card_shadow' => 'none',
                'footer_border' => '#D1D5DB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],

            // ─── SPÉCIALISÉS ───
            'videaste' => [
                'id' => 10,
                'slug' => 'videaste',
                'name' => 'Vidéaste',
                'description' => 'Header animé + particules + vidéo',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'videaste',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'button_style' => 'rounded',
                'features' => ['video_embed'],
                'feature_limits' => [
                    'pro' => ['videos' => 1],
                    'premium' => ['videos' => 2],
                ],
                'default_colors' => ['primary' => '#E53E3E', 'secondary' => '#742A2A'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'artiste' => [
                'id' => 11,
                'slug' => 'artiste',
                'name' => 'Artiste',
                'description' => 'Carrousel galerie swipe',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'artiste',
                'transition' => 'arch',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'button_style' => 'rounded',
                'features' => ['image_carousel'],
                'feature_limits' => [
                    'pro' => ['carousels' => 1, 'images_per_carousel' => 6],
                    'premium' => ['carousels' => 2, 'images_per_carousel' => 12],
                ],
                'band_adjustments' => [
                    'social_links' => -2,
                    'text_blocks' => -1,
                ],
                'default_colors' => ['primary' => '#D69E2E', 'secondary' => '#744210'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
            'entrepreneur' => [
                'id' => 12,
                'slug' => 'entrepreneur',
                'name' => 'Entrepreneur',
                'description' => 'Double photo + gros CTA carrés',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'entrepreneur',
                'transition' => 'diagonal',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'button_style' => 'square_wide',
                'features' => ['cta_buttons'],
                'feature_limits' => [
                    'pro' => ['cta_buttons' => 3],
                    'premium' => ['cta_buttons' => 6],
                ],
                'default_colors' => ['primary' => '#2C2A27', 'secondary' => '#4B5563'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],

            // ─── CUSTOM ───
            'custom' => [
                'id' => 13,
                'slug' => 'custom',
                'name' => 'Mon Style',
                'description' => '100% personnalisable',
                'category' => 'custom',
                'required_plan' => 'premium',
                'header_style' => 'classic',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'button_style' => 'rounded',
                'features' => ['video_embed', 'image_carousel', 'cta_buttons'],
                'feature_limits' => [
                    'premium' => [
                        'videos' => 2,
                        'carousels' => 2,
                        'images_per_carousel' => 12,
                        'cta_buttons' => 6,
                    ],
                ],
                'customizable' => [
                    'header_style',
                    'transition',
                    'photo_style',
                    'social_style',
                    'button_style',
                    'text_color',
                    'button_color',
                ],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
                'body_bg' => '#FFFFFF',
                'body_text' => '#2C2A27',
                'card_bg' => '#F9FAFB',
                'card_border' => '#E5E7EB',
                'card_shadow' => 'sm',
                'footer_border' => '#E5E7EB',
                'footer_text' => '#9CA3AF',
                'dark_mode' => false,
            ],
        ];
    }

    /**
     * Get a single template by slug.
     */
    public static function get(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }

    /**
     * Get default template slug.
     */
    public static function default(): string
    {
        return 'classic';
    }

    /**
     * Get templates available for a given plan.
     */
    public static function forPlan(string $plan): array
    {
        $planHierarchy = ['free' => 0, 'pro' => 1, 'premium' => 2];
        $userLevel = $planHierarchy[$plan] ?? 0;

        return array_filter(self::all(), function ($template) use ($planHierarchy, $userLevel) {
            $requiredLevel = $planHierarchy[$template['required_plan']] ?? 0;
            return $requiredLevel <= $userLevel;
        });
    }

    /**
     * Get all templates grouped by category.
     */
    public static function grouped(): array
    {
        $templates = self::all();
        $groups = [
            'general' => [],
            'specialized' => [],
            'custom' => [],
        ];

        foreach ($templates as $template) {
            $groups[$template['category']][] = $template;
        }

        return $groups;
    }

    /**
     * Check if a user can use a specific template.
     */
    public static function canUse(string $slug, string $plan): bool
    {
        $template = self::get($slug);
        if (!$template) return false;

        $planHierarchy = ['free' => 0, 'pro' => 1, 'premium' => 2];
        $userLevel = $planHierarchy[$plan] ?? 0;
        $requiredLevel = $planHierarchy[$template['required_plan']] ?? 0;

        return $userLevel >= $requiredLevel;
    }

    /**
     * Get the required plan label for upgrade prompts.
     */
    public static function requiredPlanLabel(string $slug): string
    {
        $template = self::get($slug);
        if (!$template) return 'PREMIUM';

        return match ($template['required_plan']) {
            'pro' => 'PRO',
            'premium' => 'PREMIUM',
            default => 'GRATUIT',
        };
    }

    /**
     * Get header style options (for Custom template).
     */
    public static function headerStyles(): array
    {
        return [
            'classic' => 'Classique',
            'wave' => 'Vague',
            'minimal' => 'Épuré',
            'diagonal' => 'Élan',
            'arch' => 'Arche',
            'split' => 'Duo',
            'banner' => 'Vitrine',
            'geometric' => 'Prisme',
            'bold' => 'Contraste',
            'videaste' => 'Vidéaste',
            'artiste' => 'Artiste',
            'entrepreneur' => 'Entrepreneur',
        ];
    }

    /**
     * Get transition options (for Custom template).
     */
    public static function transitions(): array
    {
        return [
            'wave' => 'Vague',
            'double_wave' => 'Double vague',
            'arch' => 'Arche',
            'diagonal' => 'Élan',
            'chevron' => 'Prisme',
            'none' => 'Aucune',
        ];
    }

    /**
     * Get social display style options (for Custom template).
     */
    public static function socialStyles(): array
    {
        return [
            'pills' => 'Pills (badges)',
            'circles' => 'Cercles (icônes)',
            'list' => 'Liste détaillée',
        ];
    }

    /**
     * Get photo style options (for Custom template).
     */
    public static function photoStyles(): array
    {
        return [
            'round_center' => 'Ronde centrée',
            'round_overlap' => 'Ronde débordante',
            'square_center' => 'Carrée arrondie',
        ];
    }

    /**
     * Get button style options (for Custom template).
     */
    public static function buttonStyles(): array
    {
        return [
            'rounded' => 'Arrondis',
            'square' => 'Carrés',
            'square_wide' => 'Pleine largeur',
            'outline_compact' => 'Contour',
        ];
    }

    /**
     * Get feature limits for a template + plan combo.
     */
    public static function getFeatureLimits(string $slug, string $plan): array
    {
        $template = self::get($slug);
        if (!$template || empty($template['feature_limits'])) return [];

        // Return limits for user's plan, or the highest available
        return $template['feature_limits'][$plan]
            ?? $template['feature_limits']['premium']
            ?? $template['feature_limits']['pro']
            ?? [];
    }

    /**
     * Get band adjustments for specialized templates.
     */
    public static function getBandAdjustments(string $slug): array
    {
        $template = self::get($slug);
        return $template['band_adjustments'] ?? [];
    }
}
