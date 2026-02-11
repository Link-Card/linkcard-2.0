<?php

namespace App\Services;

use App\Models\User;

class OnboardingService
{
    /**
     * Get all onboarding steps with completion status.
     * Only returns steps that are relevant (no pre-completed fluff).
     */
    public static function getSteps(User $user): array
    {
        $profile = $user->profiles()->first();
        $steps = [];

        // Step: Verify email — ONLY if not verified
        if ($user->email_verified_at === null) {
            $steps[] = [
                'key' => 'email_verified',
                'label' => 'Vérifier votre email',
                'completed' => false,
                'action' => route('verification.notice'),
                'icon' => 'email',
                'dismissable' => false,
            ];
        }

        // Step: Add photo
        $steps[] = [
            'key' => 'photo',
            'label' => 'Ajouter votre photo',
            'completed' => $profile && $profile->photo_path !== null,
            'action' => $profile ? route('profile.edit', $profile) . '?focus=photo' : route('profile.create'),
            'icon' => 'photo',
            'dismissable' => false,
        ];

        // Step: Add a section (any content band)
        $steps[] = [
            'key' => 'add_section',
            'label' => 'Ajouter une section',
            'completed' => $profile && $profile->contentBands()
                ->where('is_hidden', false)
                ->exists(),
            'action' => $profile ? route('profile.edit', $profile) : route('profile.create'),
            'icon' => 'section',
            'dismissable' => false,
        ];

        // Step: Share profile (require 2+ views to avoid self-view counting)
        $steps[] = [
            'key' => 'shared',
            'label' => 'Partager votre profil',
            'completed' => $profile && $profile->view_count >= 2,
            'action' => $profile ? route('profile.public', $profile->username) : null,
            'icon' => 'share',
            'dismissable' => false,
        ];

        // Step: Order NFC card — show only for first 7 days AND if no cards
        $hasCards = $user->cards()->exists();
        $accountAge = $user->created_at ? $user->created_at->diffInDays(now()) : 0;

        if (!$hasCards && $accountAge <= 7) {
            $steps[] = [
                'key' => 'order_card',
                'label' => 'Commander votre première carte NFC',
                'completed' => $user->cardOrders()->exists(),
                'action' => route('cards.order'),
                'icon' => 'card',
                'dismissable' => true,
            ];
        }

        return $steps;
    }

    /**
     * Get completion percentage.
     */
    public static function getProgress(User $user): int
    {
        $steps = self::getSteps($user);
        if (empty($steps)) return 100;

        $completed = collect($steps)->where('completed', true)->count();
        return (int) round(($completed / count($steps)) * 100);
    }

    /**
     * Check if all steps are completed.
     */
    public static function isComplete(User $user): bool
    {
        $steps = self::getSteps($user);
        if (empty($steps)) return true;
        return collect($steps)->where('completed', false)->isEmpty();
    }

    /**
     * Should we show the onboarding modal?
     * Skip for existing users who already have a profile set up.
     */
    public static function shouldShowModal(User $user): bool
    {
        // Only for users created after the tour feature launch
        if ($user->created_at && $user->created_at->lt(now()->startOfDay())) {
            return false;
        }

        // Already seen or dismissed
        if ($user->onboarding_completed_at !== null || $user->onboarding_dismissed_at !== null) {
            return false;
        }

        return true;
    }

    /**
     * Should we show the checklist banner?
     */
    public static function shouldShowChecklist(User $user): bool
    {
        // Only for users created after the tour feature launch
        if ($user->created_at && $user->created_at->lt(now()->startOfDay())) {
            return false;
        }

        // Don't show if all complete
        if (self::isComplete($user)) {
            return false;
        }

        // Don't show if marked complete
        if ($user->onboarding_completed_at !== null) {
            return false;
        }

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
