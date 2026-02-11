<?php

namespace App\Services;

use App\Models\User;

class OnboardingService
{
    /**
     * Get all onboarding steps with completion status.
     */
    public static function getSteps(User $user): array
    {
        $profile = $user->profiles()->first();

        return [
            [
                'key' => 'account',
                'label' => 'Créer votre compte',
                'completed' => true,
                'action' => null,
            ],
            [
                'key' => 'email_verified',
                'label' => 'Vérifier votre email',
                'completed' => $user->email_verified_at !== null,
                'action' => route('verification.notice'),
            ],
            [
                'key' => 'photo',
                'label' => 'Ajouter votre photo',
                'completed' => $profile && $profile->photo_path !== null,
                'action' => $profile ? route('profile.edit', $profile) : route('profile.create'),
            ],
            [
                'key' => 'social_link',
                'label' => 'Ajouter un lien social',
                'completed' => $profile && $profile->contentBands()
                    ->where('type', 'social_link')
                    ->where('is_hidden', false)
                    ->exists(),
                'action' => $profile ? route('profile.edit', $profile) : route('profile.create'),
            ],
            [
                'key' => 'shared',
                'label' => 'Partager votre profil',
                'completed' => $profile && $profile->view_count > 0,
                'action' => $profile ? route('profile.public', $profile->username) : null,
            ],
        ];
    }

    /**
     * Get completion percentage.
     */
    public static function getProgress(User $user): int
    {
        $steps = self::getSteps($user);
        $completed = collect($steps)->where('completed', true)->count();
        return (int) round(($completed / count($steps)) * 100);
    }

    /**
     * Check if all steps are completed.
     */
    public static function isComplete(User $user): bool
    {
        return self::getProgress($user) === 100;
    }

    /**
     * Should we show the onboarding modal?
     * Skip for existing users who already have a profile set up.
     */
    public static function shouldShowModal(User $user): bool
    {
        // Already seen or dismissed
        if ($user->onboarding_completed_at !== null || $user->onboarding_dismissed_at !== null) {
            return false;
        }

        // Existing user with a profile already set up — skip modal
        $profile = $user->profiles()->first();
        if ($profile && $profile->photo_path !== null) {
            return false;
        }

        return true;
    }

    /**
     * Should we show the checklist banner?
     */
    public static function shouldShowChecklist(User $user): bool
    {
        // Don't show if all complete
        if (self::isComplete($user)) {
            return false;
        }

        // Don't show if completed onboarding already
        if ($user->onboarding_completed_at !== null) {
            return false;
        }

        // Show even if dismissed (it comes back next login)
        // But don't show if dismissed in this session
        return true;
    }

    /**
     * Mark onboarding as complete.
     */
    public static function markComplete(User $user): void
    {
        $user->update(['onboarding_completed_at' => now()]);
    }

    /**
     * Dismiss the checklist temporarily.
     */
    public static function dismiss(User $user): void
    {
        $user->update(['onboarding_dismissed_at' => now()]);
    }
}
