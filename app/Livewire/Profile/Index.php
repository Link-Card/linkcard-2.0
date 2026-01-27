<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $profiles;
    public $profileCount;
    public $profileLimit;
    public $canCreateMore;
    public $userPlan;
    public $additionalProfilesCount;

    public function mount()
    {
        $this->loadProfiles();
        $this->calculateLimits();
    }

    public function loadProfiles()
    {
        $this->profiles = Auth::user()->profiles()
            ->with('template')
            ->latest()
            ->get();
        
        $this->profileCount = $this->profiles->count();
    }

    public function calculateLimits()
    {
        $user = Auth::user();
        $this->userPlan = $user->plan ?? 'free';
        $this->additionalProfilesCount = $user->additional_profiles_count ?? 0;

        switch (strtolower($this->userPlan)) {
            case 'free':
                $this->profileLimit = 1;
                break;
            case 'pro':
            case 'premium':
                $this->profileLimit = 1 + $this->additionalProfilesCount;
                break;
            default:
                $this->profileLimit = 1;
        }

        $this->canCreateMore = $this->profileCount < $this->profileLimit;
    }

    public function deleteProfile($profileId)
    {
        $profile = Profile::where('id', $profileId)
            ->where('user_id', Auth::id())
            ->first();

        if ($profile) {
            $profile->sections()->delete();
            $profile->links()->delete();
            $profile->galleryItems()->delete();
            
            $profile->delete();

            session()->flash('success', 'Profil supprimé avec succès.');
            
            $this->loadProfiles();
            $this->calculateLimits();
        } else {
            session()->flash('error', 'Profil introuvable.');
        }
    }

    public function render()
    {
        return view('livewire.profile.index')
            ->layout('layouts.dashboard');
    }
}
