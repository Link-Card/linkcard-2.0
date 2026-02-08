<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;

class ReferralService
{
    const REFERRALS_PER_REWARD = 10;
    const MAX_BONUS_MONTHS = 12;

    /**
     * Vérifie si le programme est actif.
     */
    public static function isActive(): bool
    {
        return config('services.referral.enabled', true);
    }

    /**
     * Enregistre un referral lors de la création d'un compte.
     */
    public static function trackReferral(string $referralCode, int $newUserId): bool
    {
        if (!self::isActive()) {
            return false;
        }

        // Chercher par referral_code d'abord, puis par username de profil
        $referrer = User::where('referral_code', $referralCode)->first();

        if (!$referrer) {
            // Fallback: chercher par username de profil
            $profile = \App\Models\Profile::where('username', $referralCode)->first();
            $referrer = $profile?->user;
        }

        if (!$referrer || $referrer->id === $newUserId) {
            return false;
        }

        // Vérifier si déjà référé
        if (Referral::where('referred_user_id', $newUserId)->exists()) {
            return false;
        }

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_user_id' => $newUserId,
            'source' => 'profile_button',
        ]);

        // Mettre à jour le referred_by du user
        User::where('id', $newUserId)->update(['referred_by' => $referrer->id]);

        // Vérifier et attribuer récompense
        self::checkAndReward($referrer->id);

        return true;
    }

    /**
     * Vérifie si le referrer a atteint 10 et attribue la récompense.
     */
    public static function checkAndReward(int $referrerId): bool
    {
        $user = User::find($referrerId);
        if (!$user) {
            return false;
        }

        // Vérifier limite max
        if ($user->premium_bonus_months >= self::MAX_BONUS_MONTHS) {
            return false;
        }

        $unrewarded = Referral::where('referrer_id', $referrerId)
            ->where('rewarded', false)
            ->count();

        if ($unrewarded >= self::REFERRALS_PER_REWARD) {
            // Marquer les 10 premiers comme rewarded
            Referral::where('referrer_id', $referrerId)
                ->where('rewarded', false)
                ->oldest()
                ->limit(self::REFERRALS_PER_REWARD)
                ->update(['rewarded' => true]);

            // Ajouter 1 mois bonus (max 12)
            $newTotal = min($user->premium_bonus_months + 1, self::MAX_BONUS_MONTHS);
            $user->update(['premium_bonus_months' => $newTotal]);

            // Si user Free → upgrade à Premium
            if ($user->plan === 'free') {
                $user->update(['plan' => 'premium']);
            }

            return true;
        }

        return false;
    }

    /**
     * Progression du referral pour un user.
     */
    public static function getProgress(int $userId): array
    {
        $unrewarded = Referral::where('referrer_id', $userId)
            ->where('rewarded', false)
            ->count();

        $totalRewarded = Referral::where('referrer_id', $userId)
            ->where('rewarded', true)
            ->count();

        $user = User::find($userId);

        return [
            'current' => $unrewarded % self::REFERRALS_PER_REWARD,
            'target' => self::REFERRALS_PER_REWARD,
            'totalReferrals' => $unrewarded + $totalRewarded,
            'bonusMonthsEarned' => $user?->premium_bonus_months ?? 0,
            'bonusMonthsUsed' => $user?->premium_bonus_used ?? 0,
            'bonusMonthsRemaining' => ($user?->premium_bonus_months ?? 0) - ($user?->premium_bonus_used ?? 0),
            'maxReached' => ($user?->premium_bonus_months ?? 0) >= self::MAX_BONUS_MONTHS,
            'isActive' => self::isActive(),
        ];
    }

    /**
     * Génère un referral_code unique pour un user.
     */
    public static function generateCode(User $user): string
    {
        // Utiliser le username du premier profil s'il existe, sinon code aléatoire
        $profile = $user->profiles()->first();

        if ($profile && $profile->username) {
            $code = strtoupper($profile->username);
        } else {
            $code = self::generateUniqueCode();
        }

        $user->update(['referral_code' => $code]);

        return $code;
    }

    /**
     * Génère un code unique 8 caractères.
     */
    private static function generateUniqueCode(): string
    {
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
