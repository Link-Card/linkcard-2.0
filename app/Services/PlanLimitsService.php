<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;

class PlanLimitsService
{
    public const LIMITS = [
        'free' => [
            'profiles' => 1,
            'social_links' => 2,
            'images' => 2,
            'text_blocks' => 1,
        ],
        'pro' => [
            'profiles' => 1,
            'social_links' => 5,
            'images' => 5,
            'text_blocks' => 2,
        ],
        'premium' => [
            'profiles' => 1,
            'social_links' => 10,
            'images' => 10,
            'text_blocks' => 5,
        ],
    ];

    public static function getLimits(string $plan): array
    {
        return self::LIMITS[$plan] ?? self::LIMITS['free'];
    }

    public static function applyLimitsOnDowngrade(User $user): array
    {
        $limits = self::getLimits($user->plan);
        $hiddenItems = [];

        foreach ($user->profiles as $profile) {
            $hiddenItems[$profile->id] = self::applyProfileLimits($profile, $limits);

            // Si downgrade à FREE → revert le custom URL vers un code aléatoire
            if ($user->plan === 'free' && $profile->username_changed_at) {
                self::revertCustomUrl($profile);
            }
        }

        return $hiddenItems;
    }

    /**
     * Revert un custom URL vers un code aléatoire (downgrade à free)
     */
    public static function revertCustomUrl(Profile $profile): void
    {
        $customUsername = $profile->username;

        // Générer un nouveau code aléatoire 8 chars
        $charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= $charset[random_int(0, strlen($charset) - 1)];
            }
        } while (Profile::where('username', $code)->exists());

        // Sauvegarder l'ancien custom URL en redirect 90 jours
        \App\Models\UsernameRedirect::updateOrCreate(
            ['old_username' => strtolower($customUsername)],
            ['profile_id' => $profile->id, 'expires_at' => now()->addDays(90)]
        );

        // Mettre à jour le profil
        $profile->update([
            'username' => $code,
            'username_changed_at' => null, // Reset pour permettre un futur changement si re-upgrade
        ]);

        // Regénérer le QR Code
        try {
            $profileUrl = route('profile.public', $code);
            $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(500)->generate($profileUrl));
            $profile->update(['qr_code' => $qrCode]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('QR code regen failed on downgrade: ' . $e->getMessage());
        }
    }

    public static function applyProfileLimits(Profile $profile, array $limits): array
    {
        $hidden = [
            'social_links' => 0,
            'images' => 0,
            'text_blocks' => 0,
        ];

        // Social links et text blocks - compter par bande
        foreach (['social_link' => 'social_links', 'text_block' => 'text_blocks'] as $bandType => $limitKey) {
            $bands = $profile->contentBands()
                ->where('type', $bandType)
                ->where('is_hidden', false)
                ->orderBy('order')
                ->get();

            $limit = $limits[$limitKey];
            $count = 0;

            foreach ($bands as $band) {
                $count++;
                if ($count > $limit) {
                    $band->update([
                        'is_hidden' => true,
                        'hidden_reason' => 'plan_limit',
                    ]);
                    $hidden[$limitKey]++;
                }
            }
        }

        // Images - compter les images individuelles dans le JSON
        $imageBands = $profile->contentBands()
            ->where('type', 'image')
            ->where('is_hidden', false)
            ->orderBy('order')
            ->get();

        $imageLimit = $limits['images'];
        $totalImages = 0;

        foreach ($imageBands as $band) {
            $data = $band->data;
            $imagesInBand = count($data['images'] ?? []);
            
            $totalImages += $imagesInBand;
            
            if ($totalImages > $imageLimit) {
                $band->update([
                    'is_hidden' => true,
                    'hidden_reason' => 'plan_limit',
                ]);
                $hidden['images'] += $imagesInBand;
            }
        }

        return $hidden;
    }

    public static function unhideOnUpgrade(User $user): int
    {
        $limits = self::getLimits($user->plan);
        $unhiddenCount = 0;

        foreach ($user->profiles as $profile) {
            // Réinitialiser d'abord toutes les bandes masquées par plan_limit
            $profile->contentBands()
                ->where('is_hidden', true)
                ->where('hidden_reason', 'plan_limit')
                ->update([
                    'is_hidden' => false,
                    'hidden_reason' => null,
                ]);
            
            // Puis réappliquer les limites du nouveau plan
            $hidden = self::applyProfileLimits($profile, $limits);
            
            // Compter celles qui sont restées visibles
            $unhiddenCount += $profile->contentBands()
                ->where('is_hidden', false)
                ->count();
        }

        return $unhiddenCount;
    }

    public static function getCurrentUsage(Profile $profile): array
    {
        $bands = $profile->contentBands()->where('is_hidden', false)->get();
        
        $usage = [
            'social_links' => 0,
            'images' => 0,
            'text_blocks' => 0,
        ];

        foreach ($bands as $band) {
            switch ($band->type) {
                case 'social_link':
                    $usage['social_links']++;
                    break;
                case 'text_block':
                    $usage['text_blocks']++;
                    break;
                case 'image':
                    $data = $band->data;
                    $usage['images'] += count($data['images'] ?? []);
                    break;
            }
        }

        return $usage;
    }

    public static function getTotalUsageIncludingHidden(Profile $profile): array
    {
        $bands = $profile->contentBands()->get();
        
        $usage = [
            'social_links' => 0,
            'images' => 0,
            'text_blocks' => 0,
        ];

        foreach ($bands as $band) {
            switch ($band->type) {
                case 'social_link':
                    $usage['social_links']++;
                    break;
                case 'text_block':
                    $usage['text_blocks']++;
                    break;
                case 'image':
                    $data = $band->data;
                    $usage['images'] += count($data['images'] ?? []);
                    break;
            }
        }

        return $usage;
    }

    /**
     * Détermine le forfait minimum requis pour tout débloquer
     */
    public static function getRequiredPlanForAll(Profile $profile): string
    {
        $totalUsage = self::getTotalUsageIncludingHidden($profile);
        
        // Vérifier si Premium suffit
        $premiumLimits = self::LIMITS['premium'];
        if ($totalUsage['social_links'] <= $premiumLimits['social_links'] &&
            $totalUsage['images'] <= $premiumLimits['images'] &&
            $totalUsage['text_blocks'] <= $premiumLimits['text_blocks']) {
            
            // Vérifier si PRO suffit
            $proLimits = self::LIMITS['pro'];
            if ($totalUsage['social_links'] <= $proLimits['social_links'] &&
                $totalUsage['images'] <= $proLimits['images'] &&
                $totalUsage['text_blocks'] <= $proLimits['text_blocks']) {
                return 'pro';
            }
            return 'premium';
        }
        
        return 'premium'; // Max possible
    }

    public static function canAdd(Profile $profile, string $type, int $count = 1): bool
    {
        $user = $profile->user;
        $limits = self::getLimits($user->plan);
        $usage = self::getCurrentUsage($profile);

        $limitKey = match($type) {
            'social_link' => 'social_links',
            'image' => 'images',
            'text_block' => 'text_blocks',
            default => null
        };

        if (!$limitKey) {
            return true;
        }

        return ($usage[$limitKey] + $count) <= $limits[$limitKey];
    }

    public static function getRemainingSlots(Profile $profile): array
    {
        $user = $profile->user;
        $limits = self::getLimits($user->plan);
        $usage = self::getCurrentUsage($profile);

        return [
            'social_links' => max(0, $limits['social_links'] - $usage['social_links']),
            'images' => max(0, $limits['images'] - $usage['images']),
            'text_blocks' => max(0, $limits['text_blocks'] - $usage['text_blocks']),
        ];
    }
}
