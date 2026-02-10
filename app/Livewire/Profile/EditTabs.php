<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\Link;
use App\Models\ImageBand;
use Illuminate\Support\Facades\Storage;

class EditTabs extends Component
{
    use WithFileUploads;

    public Profile $profile;
    public $activeTab = 'informations';

    // Tab Informations
    public $full_name;
    public $job_title;
    public $company;
    public $location;
    public $email;
    public $phone;
    public $website;

    // Tab Design
    public $primary_color;
    public $photo;

    // Tab Band
    public $contact_button_position;
    public $bio;
    public $links = [];
    public $bands = [];
    public $newLinkPlatform = '';
    public $newLinkUrl = '';

    public function updatedNewLinkUrl($value)
    {
        if ($value && !preg_match('~^(?:f|ht)tps?://~i', $value)) {
            $this->newLinkUrl = 'https://' . $value;
        }
    }

    public function mount(Profile $profile)
    {
        // Vérifier que l'utilisateur possède ce profil
        if ($profile->user_id !== auth()->id()) {
            abort(403);
        }

        $this->profile = $profile;
        $this->loadData();
    }

    public function loadData()
    {
        // Charger données Informations
        $this->full_name = $this->profile->full_name;
        $this->job_title = $this->profile->job_title;
        $this->company = $this->profile->company;
        $this->location = $this->profile->location;
        $this->email = $this->profile->email;
        $this->phone = $this->profile->phone;
        $this->website = $this->profile->website;

        // Charger données Design
        $this->primary_color = $this->profile->primary_color ?? '#2D7A4F';

        // Charger données Band
        $this->contact_button_position = $this->profile->contact_button_position ?? 0;
        $this->bio = $this->profile->bio;
        $this->links = $this->profile->links()->get()->toArray();
        $this->bands = $this->profile->imageBands()->with('images')->get()->toArray();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // ========== TAB INFORMATIONS ==========
    public function saveInformations()
    {
        $this->validate([
            'full_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
        ]);

        $this->profile->update([
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'location' => $this->location,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
        ]);

        session()->flash('success', 'Informations sauvegardées avec succès!');
    }

    // ========== TAB DESIGN ==========
    public function saveDesign()
    {
        $this->validate([
            'primary_color' => 'required|string',
            'photo' => 'nullable|image|max:10240',
        ]);

        $data = [
            'primary_color' => $this->primary_color,
        ];

        // Upload nouvelle photo si présente
        if ($this->photo) {
            // Supprimer ancienne photo
            if ($this->profile->photo_path) {
                Storage::disk('public')->delete($this->profile->photo_path);
            }

            $data['photo_path'] = $this->photo->store('profile-photos', 'public');
        }

        $this->profile->update($data);

        $this->reset('photo');
        session()->flash('success', 'Design sauvegardé avec succès!');
    }

    // ========== TAB BAND - LIENS SOCIAUX ==========
    public function addLink()
    {
        $this->validate([
            'newLinkPlatform' => 'required|string',
            'newLinkUrl' => 'required|url',
        ]);

        // Vérifier limites plan
        $user = auth()->user();
        $currentLinksCount = $this->profile->links()->count();
        
        $maxLinks = match($user->plan) {
            'free' => 3,
            'pro' => 10,
            'premium' => 999,
            default => 3
        };

        if ($currentLinksCount >= $maxLinks) {
            session()->flash('link-error', 'Vous avez utilisé tous vos liens sociaux. Passez au forfait supérieur pour en ajouter.');
            return;
        }

        Link::create([
            'profile_id' => $this->profile->id,
            'platform' => $this->newLinkPlatform,
            'url' => $this->newLinkUrl,
            'order' => $currentLinksCount,
        ]);

        $this->reset(['newLinkPlatform', 'newLinkUrl']);
        $this->loadData();
        session()->flash('link-success', 'Lien ajouté avec succès!');
    }

    public function deleteLink($linkId)
    {
        $link = Link::findOrFail($linkId);
        
        if ($link->profile_id !== $this->profile->id) {
            abort(403);
        }

        $link->delete();
        $this->loadData();
        session()->flash('link-success', 'Lien supprimé avec succès!');
    }

    // ========== TAB BAND - BANDES IMAGES ==========
    public function addBand()
    {
        // Vérifier limites plan
        $user = auth()->user();
        $currentBandsCount = $this->profile->imageBands()->count();
        
        $maxBands = match($user->plan) {
            'free' => 1,
            'pro' => 3,
            'premium' => 10,
            default => 1
        };

        if ($currentBandsCount >= $maxBands) {
            session()->flash('link-error', 'Vous avez utilisé toutes vos sections disponibles. Passez au forfait supérieur.');
            return;
        }

        ImageBand::create([
            'profile_id' => $this->profile->id,
            'band_number' => $currentBandsCount + 1,
            'order' => $currentBandsCount,
        ]);

        $this->loadData();
        session()->flash('link-success', 'Section ajoutée !');
    }

    public function saveBand()
    {
        $this->validate([
            'bio' => 'nullable|string|max:500',
            'contact_button_position' => 'nullable|integer',
        ]);

        $this->profile->update([
            'bio' => $this->bio,
            'contact_button_position' => $this->contact_button_position,
        ]);

        session()->flash('success', 'Contenu sauvegardé avec succès!');
    }

    public function render()
    {
        return view('livewire.profile.edit-tabs')
            ->layout('layouts.dashboard');
    }
}
