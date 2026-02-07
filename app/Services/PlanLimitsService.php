<?php

namespace App\Services;

use App\Models\User;
use App\Models\ContentBand;
use Illuminate\Support\Facades\Log;

class PlanLimitsService
{
    /**
     * Limites par plan
     */
    public static function getLimits(string $plan): array
    {
        return match($plan) {
            'premium' => [
                'social_links' => 10,
                'images' => 10,
                'text_blocks' => 5,
            ],
            'pro' => [
                'social_links' => 5,
                'images' => 5,
                'text_blocks' => 2,
            ],
            default => [ // free
                'social_links' => 2,
                'images' => 2,
                'text_blocks' => 1,
            ],
        };
    }

    /**
     * Applique les limites lors d'un downgrade
     */
    public static function applyLimitsOnDowngrade(User $user): void
    {
        $limits = self::getLimits($user->plan);
        
        foreach ($user->profiles as $profile) {
            self::applyProfileLimits($profile, $limits);
        }
        
        Log::info('PlanLimitsService: Limits applied on downgrade', [
            'user_id' => $user->id,
            'plan' => $user->plan
        ]);
    }

    /**
     * Démasque le contenu lors d'un upgrade
     */
    public static function unhideOnUpgrade(User $user): void
    {
        $limits = self::getLimits($user->plan);
        $unhiddenCount = 0;
        
        foreach ($user->profiles as $profile) {
            // D'abord, tout démasquer
            $unhiddenCount += ContentBand::where('profile_id', $profile->id)
                ->where('is_hidden', true)
                ->update(['is_hidden' => false, 'hidden_reason' => null]);
            
            // Puis réappliquer les nouvelles limites
            self::applyProfileLimits($profile, $limits);
        }
        
        Log::info('PlanLimitsService: Content unhidden on upgrade', [
            'user_id' => $user->id,
            'plan' => $user->plan,
            'unhidden_count' => $unhiddenCount
        ]);
    }

    /**
     * Applique les limites à un profil spécifique
     */
    protected static function applyProfileLimits($profile, array $limits): void
    {
        // Social links
        self::applyLimitToType($profile->id, 'social_link', $limits['social_links']);
        
        // Images (compter individuellement, pas par bande)
        self::applyImageLimits($profile->id, $limits['images']);
        
        // Text blocks
        self::applyLimitToType($profile->id, 'text_block', $limits['text_blocks']);
    }

    /**
     * Applique une limite à un type de contenu
     */
    protected static function applyLimitToType(int $profileId, string $type, int $limit): void
    {
        $bands = ContentBand::where('profile_id', $profileId)
            ->where('type', $type)
            ->where('is_hidden', false)
            ->orderBy('order')
            ->get();
        
        $count = 0;
        foreach ($bands as $band) {
            $count++;
            if ($count > $limit) {
                $band->update([
                    'is_hidden' => true,
                    'hidden_reason' => 'plan_limit'
                ]);
            }
        }
    }

    /**
     * Applique la limite d'images (compte individuel, pas par bande)
     */
    protected static function applyImageLimits(int $profileId, int $imageLimit): void
    {
        $imageBands = ContentBand::where('profile_id', $profileId)
            ->where('type', 'image')
            ->where('is_hidden', false)
            ->orderBy('order')
            ->get();
        
        $totalImages = 0;
        
        foreach ($imageBands as $band) {
            $data = $band->data;
            $imagesInBand = count($data['images'] ?? []);
            $totalImages += $imagesInBand;
            
            if ($totalImages > $imageLimit) {
                $band->update([
                    'is_hidden' => true,
                    'hidden_reason' => 'plan_limit'
                ]);
            }
        }
    }

    /**
     * Compte le contenu total incluant le masqué
     */
    public static function getTotalUsageIncludingHidden(User $user): array
    {
        $usage = [
            'social_links' => 0,
            'images' => 0,
            'text_blocks' => 0,
        ];
        
        foreach ($user->profiles as $profile) {
            // Social links
            $usage['social_links'] += ContentBand::where('profile_id', $profile->id)
                ->where('type', 'social_link')
                ->count();
            
            // Images (compter individuellement)
            $imageBands = ContentBand::where('profile_id', $profile->id)
                ->where('type', 'image')
                ->get();
            
            foreach ($imageBands as $band) {
                $data = $band->data;
                $usage['images'] += count($data['images'] ?? []);
            }
            
            // Text blocks
            $usage['text_blocks'] += ContentBand::where('profile_id', $profile->id)
                ->where('type', 'text_block')
                ->count();
        }
        
        return $usage;
    }

    /**
     * Détermine le plan requis pour tout le contenu
     */
    public static function getRequiredPlanForAll(User $user): string
    {
        $usage = self::getTotalUsageIncludingHidden($user);
        
        $premiumLimits = self::getLimits('premium');
        $proLimits = self::getLimits('pro');
        
        // Vérifier si Premium est requis
        if ($usage['social_links'] > $proLimits['social_links'] ||
            $usage['images'] > $proLimits['images'] ||
            $usage['text_blocks'] > $proLimits['text_blocks']) {
            return 'premium';
        }
        
        // Vérifier si Pro est requis
        $freeLimits = self::getLimits('free');
        if ($usage['social_links'] > $freeLimits['social_links'] ||
            $usage['images'] > $freeLimits['images'] ||
            $usage['text_blocks'] > $freeLimits['text_blocks']) {
            return 'pro';
        }
        
        return 'free';
    }
}
