<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Create extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    // Étape 1: Informations
    public $full_name;
    public $job_title;
    public $company;
    public $location;
    public $bio;
    public $email;
    public $phone;
    public $website;

    // Étape 2: Design
    public $template_id = 1;
    public $primary_color = '#2D7A4F';

    // Étape 3: Photo
    public $photo;
    public $photoPreview;

    protected $rules = [
        'full_name' => 'required|string|max:100',
        'job_title' => 'nullable|string|max:100',
        'company' => 'nullable|string|max:100',
        'location' => 'nullable|string|max:100',
        'bio' => 'nullable|string|max:500',
        'email' => 'nullable|email|max:100',
        'phone' => 'nullable|string|max:20',
        'website' => 'nullable|url|max:255',
        'primary_color' => 'required|string',
        'photo' => 'nullable|image|max:10240',
    ];

    public function mount()
    {
        // Vérifier limites plan - CORRECTION BUG
        $user = auth()->user();
        $profilesCount = $user->profiles()->count();
        
        // FREE: 1 profil max (pas de additional_profiles_count)
        // PRO/PREMIUM: 1 + additional_profiles_count
        $maxProfiles = 1;
        if (in_array($user->plan, ['pro', 'premium'])) {
            $maxProfiles = 1 + ($user->additional_profiles_count ?? 0);
        }

        if ($profilesCount >= $maxProfiles) {
            session()->flash('error', 'Vous avez atteint la limite de profils pour votre plan.');
            return redirect()->route('profile.index');
        }
    }

    public function updatedWebsite($value)
    {
        if ($value && !preg_match("~^(?:f|ht)tps?://~i", $value)) {
            $this->website = 'https://' . $value;
        }
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:10240',
        ]);

        $this->photoPreview = $this->photo->temporaryUrl();
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'full_name' => 'required|string|max:100',
                'job_title' => 'nullable|string|max:100',
                'company' => 'nullable|string|max:100',
                'location' => 'nullable|string|max:100',
                'bio' => 'nullable|string|max:500',
                'email' => 'nullable|email|max:100',
                'phone' => 'nullable|string|max:20',
                'website' => 'nullable|url|max:255',
            ]);
        }

        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function save()
    {
        $this->validate();

        // Générer username unique
        do {
            $username = $this->generateUsername();
        } while (Profile::where('username', $username)->exists());

        // Upload photo si présente
        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('profile-photos', 'public');
        }

        // Créer profil
        $profile = Profile::create([
            'user_id' => auth()->id(),
            'username' => $username,
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'location' => $this->location,
            'bio' => $this->bio,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'template_id' => $this->template_id,
            'primary_color' => $this->primary_color,
            'photo_path' => $photoPath,
            'is_public' => true,
        ]);

        // Générer QR Code (base64)
        $profileUrl = route('profile.public', $profile->username);
        $qrCode = base64_encode(QrCode::format('png')->size(500)->generate($profileUrl));
        
        $profile->update(['qr_code' => $qrCode]);

        session()->flash('success', 'Profil créé avec succès!');
        return redirect()->route('profile.index');
    }

    private function generateUsername()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Évite 0,O,1,l,I
        $username = '';
        for ($i = 0; $i < 8; $i++) {
            $username .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $username;
    }

    public function render()
    {
        return view('livewire.profile.create');
    }
}
