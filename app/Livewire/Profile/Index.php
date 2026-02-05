<?php
namespace App\Livewire\Profile;
use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Traits\WithDeleteConfirmation;

class Index extends Component
{
    use WithDeleteConfirmation;
    
    public $profiles;
    public $profilesCount;
    public $maxProfiles;
    public $canCreateMore;

    public function mount()
    {
        $this->loadProfiles();
    }

    public function loadProfiles()
    {
        $user = auth()->user();
        $this->profiles = $user->profiles()->orderBy('created_at', 'desc')->get();
        $this->profilesCount = $this->profiles->count();
        $limits = ['free' => 1, 'pro' => 1, 'premium' => 1];
        $this->maxProfiles = $limits[$user->plan ?? 'free'] ?? 1;
        $this->canCreateMore = $this->profilesCount < $this->maxProfiles;
    }

    public function confirmReset($profileId)
    {
        $profile = Profile::find($profileId);
        if (!$profile || $profile->user_id !== auth()->id()) return;
        
        // Utilise le trait existant
        $this->confirmDeleteItem($profileId, $profile->full_name, 'ce profil');
    }

    public function resetConfirmed()
    {
        if (!$this->deletingItemId) return;
        
        $profile = Profile::findOrFail($this->deletingItemId);
        if ($profile->user_id !== auth()->id()) abort(403);

        // Supprimer la photo
        if ($profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
            $profile->photo_path = null;
        }

        // Supprimer les bandes de contenu (garder le profil)
        foreach ($profile->contentBands as $band) {
            if ($band->type === 'image') {
                $images = $band->data['images'] ?? [];
                if (empty($images) && isset($band->data['path'])) {
                    Storage::disk('public')->delete($band->data['path']);
                } else {
                    foreach ($images as $img) {
                        if (isset($img['path'])) Storage::disk('public')->delete($img['path']);
                    }
                }
            }
            $band->delete();
        }

        // Réinitialiser les champs du profil (GARDER l'URL!)
        $profile->update([
            'full_name' => 'Mon Profil',
            'job_title' => null,
            'company' => null,
            'location' => null,
            'email' => null,
            'phone' => null,
            'website' => null,
            'bio' => null,
            'photo_path' => null,
            'primary_color' => '#42B574',
            'secondary_color' => '#2D7A4F',
        ]);

        $this->cancelDelete();
        $this->loadProfiles();
        
        session()->flash('message', 'Profil réinitialisé avec succès.');
    }

    public function render()
    {
        return view('livewire.profile.index')->layout('layouts.dashboard');
    }
}
