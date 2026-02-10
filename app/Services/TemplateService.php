<?php

namespace App\Services;

class TemplateService
{
    /**
     * All 13 template definitions.
     * Each template defines its visual config and plan requirements.
     */
    public static function all(): array
    {
        return [
            // ─── TOUS (Free+) ───
            'classic' => [
                'id' => 1,
                'slug' => 'classic',
                'name' => 'Classique',
                'description' => 'Dégradé plein, transition wave douce',
                'category' => 'general',
                'required_plan' => 'free', // free = tous y ont accès
                'header_style' => 'classic',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
            ],
            'wave' => [
                'id' => 2,
                'slug' => 'wave',
                'name' => 'Vague v1',
                'description' => 'Double wave comme LinkCard v1',
                'category' => 'general',
                'required_plan' => 'free',
                'header_style' => 'wave',
                'transition' => 'double_wave',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
            ],
            'minimal' => [
                'id' => 3,
                'slug' => 'minimal',
                'name' => 'Minimal',
                'description' => 'Barre accent + fond blanc épuré',
                'category' => 'general',
                'required_plan' => 'free',
                'header_style' => 'minimal',
                'transition' => 'none',
                'photo_style' => 'round_center',
                'social_style' => 'list',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
            ],

            // ─── PRO+ ───
            'diagonal' => [
                'id' => 4,
                'slug' => 'diagonal',
                'name' => 'Diagonal',
                'description' => 'Coupe en angle dynamique',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'diagonal',
                'transition' => 'diagonal',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'features' => [],
                'default_colors' => ['primary' => '#3182CE', 'secondary' => '#1A365D'],
            ],
            'arch' => [
                'id' => 5,
                'slug' => 'arch',
                'name' => 'Arche',
                'description' => 'Courbe douce élégante',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'arch',
                'transition' => 'arch',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'features' => [],
                'default_colors' => ['primary' => '#805AD5', 'secondary' => '#322659'],
            ],
            'split' => [
                'id' => 6,
                'slug' => 'split',
                'name' => 'Split',
                'description' => 'Photo à gauche, infos à droite',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'split',
                'transition' => 'wave',
                'photo_style' => 'round_left',
                'social_style' => 'pills',
                'features' => [],
                'default_colors' => ['primary' => '#E53E3E', 'secondary' => '#742A2A'],
            ],
            'banner' => [
                'id' => 7,
                'slug' => 'banner',
                'name' => 'Banner',
                'description' => 'Bannière + photo qui déborde',
                'category' => 'general',
                'required_plan' => 'pro',
                'header_style' => 'banner',
                'transition' => 'none',
                'photo_style' => 'round_overlap',
                'social_style' => 'circles',
                'features' => [],
                'default_colors' => ['primary' => '#DD6B20', 'secondary' => '#652B19'],
            ],

            // ─── PREMIUM ───
            'geometric' => [
                'id' => 8,
                'slug' => 'geometric',
                'name' => 'Géométrique',
                'description' => 'Formes abstraites + chevron',
                'category' => 'general',
                'required_plan' => 'premium',
                'header_style' => 'geometric',
                'transition' => 'chevron',
                'photo_style' => 'square_center',
                'social_style' => 'list',
                'features' => [],
                'default_colors' => ['primary' => '#38B2AC', 'secondary' => '#1D4044'],
            ],
            'bold' => [
                'id' => 9,
                'slug' => 'bold',
                'name' => 'Bold',
                'description' => 'Fond sombre, accent couleur',
                'category' => 'general',
                'required_plan' => 'premium',
                'header_style' => 'bold',
                'transition' => 'none',
                'photo_style' => 'round_center',
                'social_style' => 'list',
                'features' => [],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
            ],

            // ─── SPÉCIALISÉS ───
            'videaste' => [
                'id' => 10,
                'slug' => 'videaste',
                'name' => 'Vidéaste',
                'description' => 'Vidéo YouTube/TikTok intégrée',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'classic',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'features' => ['video_embed'],
                'feature_limits' => [
                    'pro' => ['videos' => 1],
                    'premium' => ['videos' => 2],
                ],
                'default_colors' => ['primary' => '#E53E3E', 'secondary' => '#742A2A'],
            ],
            'artiste' => [
                'id' => 11,
                'slug' => 'artiste',
                'name' => 'Artiste',
                'description' => 'Galerie carrousel d\'images',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'arch',
                'transition' => 'wave',
                'photo_style' => 'round_center',
                'social_style' => 'circles',
                'features' => ['image_carousel'],
                'feature_limits' => [
                    'pro' => ['carousels' => 1, 'images_per_carousel' => 6],
                    'premium' => ['carousels' => 2, 'images_per_carousel' => 12],
                ],
                'band_adjustments' => [
                    'social_links' => -2,  // 2 réseaux de moins que le plan normal
                    'text_blocks' => -1,   // 1 text block de moins
                ],
                'default_colors' => ['primary' => '#D69E2E', 'secondary' => '#744210'],
            ],
            'entrepreneur' => [
                'id' => 12,
                'slug' => 'entrepreneur',
                'name' => 'Entrepreneur',
                'description' => 'Boutons CTA personnalisables',
                'category' => 'specialized',
                'required_plan' => 'pro',
                'header_style' => 'diagonal',
                'transition' => 'diagonal',
                'photo_style' => 'round_center',
                'social_style' => 'pills',
                'features' => ['cta_buttons'],
                'feature_limits' => [
                    'pro' => ['cta_buttons' => 3],
                    'premium' => ['cta_buttons' => 6],
                ],
                'default_colors' => ['primary' => '#2C2A27', 'secondary' => '#4B5563'],
            ],

            // ─── CUSTOM ───
            'custom' => [
                'id' => 13,
                'slug' => 'custom',
                'name' => 'Custom',
                'description' => 'Mix & match — forme libre',
                'category' => 'custom',
                'required_plan' => 'premium',
                'header_style' => 'classic', // user choisit
                'transition' => 'wave',      // user choisit
                'photo_style' => 'round_center', // user choisit
                'social_style' => 'pills',   // user choisit
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
                    'text_color',
                    'button_color',
                ],
                'default_colors' => ['primary' => '#42B574', 'secondary' => '#2D7A4F'],
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
            'minimal' => 'Minimal',
            'diagonal' => 'Diagonal',
            'arch' => 'Arche',
            'split' => 'Split',
            'banner' => 'Banner',
            'geometric' => 'Géométrique',
            'bold' => 'Bold',
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
            'diagonal' => 'Diagonal',
            'chevron' => 'Chevron',
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
            'round_left' => 'Ronde à gauche',
            'round_overlap' => 'Ronde débordante',
            'square_center' => 'Carrée arrondie',
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
