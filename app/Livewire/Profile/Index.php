<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    public function delete($profileId)
    {
        $profile = Profile::where('id', $profileId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Supprimer la photo si existe
        if ($profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
        }

        $profile->delete();

        session()->flash('success', 'Profil supprimé avec succès.');
    }

    public function render()
    {
        $user = auth()->user();
        $profiles = Profile::where('user_id', $user->id)->get();
        $profilesCount = $profiles->count();
        $maxProfiles = 1 + ($user->additional_profiles_count ?? 0);
        $canCreateMore = $profilesCount < $maxProfiles;

        return view('livewire.profile.index', [
            'profiles' => $profiles,
            'profilesCount' => $profilesCount,
            'maxProfiles' => $maxProfiles,
            'canCreateMore' => $canCreateMore,
        ])->layout('layouts.dashboard');
    }
}
