<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    
    public $full_name = '';
    public $job_title = '';
    public $company = '';
    public $location = '';
    public $bio = '';
    public $email = '';
    public $phone = '';
    public $website = '';
    
    public $template_id = 1;
    public $primary_color = '#2D7A4F';
    
    public $photo;

    public function mount()
    {
        $user = Auth::user();
        $this->full_name = $user->name ?? '';
        $this->email = $user->email ?? '';
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
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

    public function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'full_name' => 'required|min:2|max:100',
                'job_title' => 'nullable|max:100',
                'company' => 'nullable|max:100',
                'location' => 'nullable|max:100',
                'bio' => 'nullable|max:500',
                'email' => 'nullable|email',
                'phone' => 'nullable|max:20',
                'website' => 'nullable|url',
            ]);
        }
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048',
        ]);
    }

    public function updatedWebsite()
    {
        if ($this->website && !preg_match("~^(?:f|ht)tps?://~i", $this->website)) {
            $this->website = 'https://' . $this->website;
        }
    }

    /**
     * Générer un code unique de 8 caractères (lettres + chiffres)
     * Facile à lire et à imprimer sur cartes NFC
     */
    private function generateUniqueCode()
    {
        do {
            // Générer 8 caractères aléatoires (minuscules + chiffres)
            // Éviter les caractères ambigus: 0, O, 1, l, I
            $characters = 'abcdefghjkmnpqrstuvwxyz23456789';
            $code = '';
            
            for ($i = 0; $i < 8; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
            
        } while (Profile::where('username', $code)->exists());
        
        return $code;
    }

    public function save()
    {
        $this->validate([
            'full_name' => 'required|min:2|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Générer un code unique au lieu d'un slug
        $username = $this->generateUniqueCode();

        $profile = Profile::create([
            'user_id' => Auth::id(),
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
            'is_public' => true,
            'view_count' => 0,
        ]);

        if ($this->photo) {
            $path = $this->photo->store('profiles', 'public');
            $profile->update(['photo_path' => $path]);
        }

        session()->flash('success', 'Profil créé avec succès! Votre code: ' . $username);
        return redirect()->route('profile.index');
    }

    public function render()
    {
        return view('livewire.profile.create')
            ->layout('layouts.dashboard');
    }
}
