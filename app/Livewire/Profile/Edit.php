<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\Link;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Profile $profile;
    public $full_name;
    public $job_title;
    public $company;
    public $location;
    public $bio;
    public $email;
    public $phone;
    public $website;
    public $primary_color;
    public $photo;
    public $photoPreview;
    public $currentPhoto;
    public $custom_username;
    public $canEditUsername = false;
    public $newLinkPlatform = 'facebook';
    public $newLinkUrl = '';
    public $newImages = [];

    protected function rules()
    {
        $rules = [
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

        if ($this->canEditUsername && $this->custom_username && $this->custom_username !== $this->profile->username) {
            $rules['custom_username'] = 'nullable|string|min:3|max:30|alpha_dash|unique:profiles,username';
        }

        return $rules;
    }

    public function mount(Profile $profile)
    {
        if ($profile->user_id !== auth()->id()) {
            abort(403);
        }

        $this->profile = $profile;
        $this->full_name = $profile->full_name;
        $this->job_title = $profile->job_title;
        $this->company = $profile->company;
        $this->location = $profile->location;
        $this->bio = $profile->bio;
        $this->email = $profile->email;
        $this->phone = $profile->phone;
        $this->website = $profile->website;
        $this->primary_color = $profile->primary_color;
        $this->currentPhoto = $profile->photo_path;

        $user = auth()->user();
        $this->canEditUsername = in_array($user->plan, ['pro', 'premium']);
        
        if (strlen($profile->username) != 8) {
            $this->custom_username = $profile->username;
        }
    }

    public function updatedNewLinkPlatform()
    {
        $this->newLinkUrl = '';
    }

    public function updatedWebsite($value)
    {
        if ($value && !preg_match("~^(?:f|ht)tps?://~i", $value)) {
            $this->website = 'https://' . $value;
        }
    }

    public function updatedNewLinkUrl($value)
    {
        if ($value) {
            $value = trim($value);
            
            if (preg_match('/^www\./i', $value)) {
                $this->newLinkUrl = 'https://' . $value;
            }
            elseif (!preg_match("~^(?:f|ht)tps?://~i", $value)) {
                $this->newLinkUrl = 'https://' . $value;
            }
        }
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:10240',
        ]);

        $this->photoPreview = $this->photo->temporaryUrl();
    }

    public function addLink()
    {
        $user = auth()->user();
        $currentLinksCount = $this->profile->links()->count();
        
        $maxLinks = match($user->plan) {
            'free' => 2,
            'pro' => 5,
            'premium' => 10,
            default => 2,
        };

        if ($currentLinksCount >= $maxLinks) {
            session()->flash('link-error', "Limite de liens atteinte pour le plan {$user->plan}. Max: {$maxLinks} liens.");
            return;
        }

        $this->validate([
            'newLinkPlatform' => 'required|string',
            'newLinkUrl' => 'required|url',
        ]);

        Link::create([
            'profile_id' => $this->profile->id,
            'platform' => $this->newLinkPlatform,
            'url' => $this->newLinkUrl,
            'order' => $currentLinksCount,
        ]);

        // Vider les champs
        $this->newLinkPlatform = "facebook";
        $this->newLinkUrl = "";
        session()->flash('link-success', 'Lien ajouté avec succès.');
        $this->dispatch('linkAdded');
    }

    public function deleteLink($linkId)
    {
        Link::where('id', $linkId)
            ->where('profile_id', $this->profile->id)
            ->delete();

        $this->reset("newLinkUrl", "newLinkPlatform");
        $this->newLinkPlatform = "facebook";
        $this->newLinkUrl = "";
        session()->flash('link-success', 'Lien supprimé.');
        $this->dispatch('linkAdded');
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:10240',
        ]);
    }

    public function resetImages()
    {
        $this->newImages = [];
        session()->flash('gallery-success', 'Sélection annulée.');
    }

    public function uploadImages()
    {
        if (empty($this->newImages)) {
            session()->flash('gallery-error', 'Aucune image sélectionnée.');
            return;
        }

        $this->validate([
            'newImages.*' => 'image|max:10240',
        ]);

        $user = auth()->user();
        $currentImagesCount = $this->profile->galleryItems()->count();
        
        $maxImages = match($user->plan) {
            'free' => 2,
            'pro' => 5,
            'premium' => 10,
            default => 2,
        };

        $newImagesCount = count($this->newImages);
        
        if (($currentImagesCount + $newImagesCount) > $maxImages) {
            session()->flash('gallery-error', "Limite d'images atteinte pour le plan {$user->plan}. Max: {$maxImages} images. Vous avez déjà {$currentImagesCount} image(s).");
            return;
        }

        foreach ($this->newImages as $image) {
            $path = $image->store('gallery', 'public');

            GalleryItem::create([
                'profile_id' => $this->profile->id,
                'type' => 'image',
                'path' => $path,
                'order' => $currentImagesCount,
            ]);
        }

        $this->newImages = [];
        session()->flash('gallery-success', 'Images ajoutées avec succès.');
    }

    public function deleteGalleryItem($imageId)
    {
        $image = GalleryItem::where('id', $imageId)
            ->where('profile_id', $this->profile->id)
            ->firstOrFail();

        Storage::disk('public')->delete($image->path);
        $image->delete();

        session()->flash('gallery-success', 'Image supprimée.');
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            if ($this->profile->photo_path) {
                Storage::disk('public')->delete($this->profile->photo_path);
            }

            $photoPath = $this->photo->store('profile-photos', 'public');
            $this->profile->photo_path = $photoPath;
        }

        if ($this->canEditUsername && $this->custom_username) {
            if ($this->custom_username !== $this->profile->username) {
                $exists = Profile::where('username', $this->custom_username)->exists();
                if ($exists) {
                    session()->flash('error', 'Ce username est déjà utilisé.');
                    return;
                }
                $this->profile->username = $this->custom_username;
            }
        }

        $this->profile->full_name = $this->full_name;
        $this->profile->job_title = $this->job_title;
        $this->profile->company = $this->company;
        $this->profile->location = $this->location;
        $this->profile->bio = $this->bio;
        $this->profile->email = $this->email;
        $this->profile->phone = $this->phone;
        $this->profile->website = $this->website;
        $this->profile->primary_color = $this->primary_color;

        $this->profile->save();

        session()->flash('success', 'Profil mis à jour avec succès!');
        return redirect()->route('profile.index');
    }

    public function render()
    {
        $user = auth()->user();
        
        $maxLinks = match($user->plan) {
            'free' => 2,
            'pro' => 5,
            'premium' => 10,
            default => 2,
        };

        $maxImages = match($user->plan) {
            'free' => 2,
            'pro' => 5,
            'premium' => 10,
            default => 2,
        };
        
        $links = $this->profile->fresh()->links;
        $galleryImages = $this->profile->fresh()->galleryItems;

        $canAddMoreLinks = $links->count() < $maxLinks;
        $canAddMoreImages = $galleryImages->count() < $maxImages;

        return view('livewire.profile.edit', [
            'links' => $links,
            'galleryImages' => $galleryImages,
            'maxLinks' => $maxLinks,
            'canAddMoreLinks' => $canAddMoreLinks,
            'maxImages' => $maxImages,
            'canAddMoreImages' => $canAddMoreImages,
        ])->layout('layouts.dashboard');
    }
}