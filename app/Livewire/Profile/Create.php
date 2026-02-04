<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Create extends Component
{
    public $full_name;
    public $job_title;
    public $company;

    protected $rules = [
        'full_name' => 'required|string|max:100',
        'job_title' => 'nullable|string|max:100',
        'company' => 'nullable|string|max:100',
    ];

    public function mount()
    {
        $user = auth()->user();
        $profilesCount = $user->profiles()->count();

        $maxProfiles = 1;
        if (in_array($user->plan, ['pro', 'premium'])) {
            $maxProfiles = 1 + ($user->additional_profiles_count ?? 0);
        }

        if ($profilesCount >= $maxProfiles) {
            session()->flash('error', 'Vous avez atteint la limite de profils pour votre plan.');
            return redirect()->route('profile.index');
        }
    }

    public function submit()
    {
        $this->validate();

        // Générer username unique
        do {
            $username = $this->generateUsername();
        } while (Profile::where('username', $username)->exists());

        // Créer profil avec valeurs par défaut
        $profile = Profile::create([
            'user_id' => auth()->id(),
            'username' => $username,
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'primary_color' => '#42B574',
            'is_public' => true,
        ]);

        // Générer QR Code
        $profileUrl = route('profile.public', $profile->username);
        $qrCode = base64_encode(QrCode::format('png')->size(500)->generate($profileUrl));
        $profile->update(['qr_code' => $qrCode]);

        session()->flash('success', 'Profil créé! Personnalisez-le maintenant.');
        return redirect()->route('profile.edit', $profile);
    }

    private function generateUsername()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $username = '';
        for ($i = 0; $i < 8; $i++) {
            $username .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $username;
    }

    public function render()
    {
        return view('livewire.profile.create')
            ->layout('layouts.dashboard');
    }
}
