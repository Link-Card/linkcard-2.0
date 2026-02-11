<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\OnboardingService;

class Home extends Component
{
    public bool $showOnboardingModal = false;
    public bool $showChecklist = true;

    public function mount()
    {
        $user = auth()->user();
        $this->showOnboardingModal = OnboardingService::shouldShowModal($user);
        $this->showChecklist = OnboardingService::shouldShowChecklist($user);
    }

    /**
     * Close the welcome modal (mark as seen).
     */
    public function closeModal()
    {
        $this->showOnboardingModal = false;
    }

    /**
     * Dismiss the checklist banner.
     */
    public function dismissChecklist()
    {
        $user = auth()->user();
        OnboardingService::dismiss($user);
        $this->showChecklist = false;
    }

    /**
     * Mark onboarding as fully complete.
     */
    public function completeOnboarding()
    {
        $user = auth()->user();
        OnboardingService::markComplete($user);
        $this->showChecklist = false;
    }

    public function render()
    {
        $user = auth()->user();

        $onboardingSteps = OnboardingService::getSteps($user);
        $onboardingProgress = OnboardingService::getProgress($user);
        $onboardingComplete = OnboardingService::isComplete($user);

        // Auto-complete if all steps done
        if ($onboardingComplete && $user->onboarding_completed_at === null) {
            OnboardingService::markComplete($user);
            $this->showChecklist = false;
        }

        return view('livewire.dashboard.home', [
            'onboardingSteps' => $onboardingSteps,
            'onboardingProgress' => $onboardingProgress,
            'onboardingComplete' => $onboardingComplete,
        ])->layout('layouts.dashboard');
    }
}
