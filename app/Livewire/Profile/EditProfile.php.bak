<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\ContentBand;
use Illuminate\Support\Facades\Storage;

class EditProfile extends Component
{
    use WithFileUploads;

    public Profile $profile;
    public $activeTab = 'contenu';

    // Tab Design
    public $primary_color;

    // Header (éditable via modal)
    public $full_name;
    public $job_title;
    public $company;
    public $location;
    public $email;
    public $phone;
    public $website;
    public $photo;
    public $showHeaderModal = false;

    // Tab Contenu
    public $contentBands = [];
    public $showAddBandModal = false;
    public $editingBandId = null;
    
    // Formulaires
    public $newBandType = '';
    public $newSocialPlatform = '';
    public $newSocialUrl = '';
    public $newImage;
    public $newImageLink = '';
    public $currentImagePath = '';
    public $newTextContent = '';

    public function mount(Profile $profile)
    {
        if ($profile->user_id !== auth()->id()) {
            abort(403);
        }

        $this->profile = $profile;
        $this->loadData();
    }

    public function loadData()
    {
        // Design
        $this->primary_color = $this->profile->primary_color ?? '#2D7A4F';

        // Header
        $this->full_name = $this->profile->full_name;
        $this->job_title = $this->profile->job_title;
        $this->company = $this->profile->company;
        $this->location = $this->profile->location;
        $this->email = $this->profile->email;
        $this->phone = $this->profile->phone;
        $this->website = $this->profile->website;

        // Contenu
        $this->contentBands = $this->profile->contentBands()->orderBy('order')->get()->toArray();
    }

    public function updatedNewSocialUrl($value)
    {
        if ($value && !preg_match('~^(?:f|ht)tps?://~i', $value)) {
            $this->newSocialUrl = 'https://' . $value;
        }
    }

    public function updatedNewImageLink($value)
    {
        if ($value && !preg_match('~^(?:f|ht)tps?://~i', $value)) {
            $this->newImageLink = 'https://' . $value;
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // ========== DESIGN TAB ==========
    public function saveDesign()
    {
        $this->validate([
            'primary_color' => 'required|string',
        ]);

        $this->profile->update(['primary_color' => $this->primary_color]);
        session()->flash('success', 'Couleur sauvegardée!');
    }

    // ========== HEADER MODAL ==========
    public function openHeaderModal()
    {
        $this->showHeaderModal = true;
    }

    public function closeHeaderModal()
    {
        $this->showHeaderModal = false;
        $this->reset('photo');
    }

    public function saveHeader()
    {
        $this->validate([
            'full_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'photo' => 'nullable|image|max:10240',
        ]);

        $data = [
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'location' => $this->location,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
        ];

        if ($this->photo) {
            if ($this->profile->photo_path) {
                Storage::disk('public')->delete($this->profile->photo_path);
            }
            $data['photo_path'] = $this->photo->store('profile-photos', 'public');
        }

        $this->profile->update($data);
        $this->closeHeaderModal();
        $this->loadData();
        session()->flash('success', 'Informations sauvegardées!');
    }

    // ========== LIMITES PAR PLAN ==========
    public function getAvailableBandTypes()
    {
        $user = auth()->user();
        $plan = $user->plan ?? 'free';
        
        // Compter les bandes existantes par type
        $contactCount = collect($this->contentBands)->where('type', 'contact_button')->count();
        $socialCount = collect($this->contentBands)->where('type', 'social_link')->count();
        $textCount = collect($this->contentBands)->where('type', 'text_block')->count();
        
        // Compter les images (peut être réparti sur plusieurs bandes)
        $imageCount = 0;
        foreach ($this->contentBands as $band) {
            if ($band['type'] === 'image') {
                $imageCount++; // 1 image par bande image
            }
        }

        $limits = [
            'free' => [
                'contact' => ['max' => 1, 'current' => $contactCount],
                'social' => ['max' => 2, 'current' => $socialCount],
                'image' => ['max' => 2, 'current' => $imageCount],
                'text' => ['max' => 1, 'current' => $textCount],
                'image_url' => false,
            ],
            'pro' => [
                'contact' => ['max' => 1, 'current' => $contactCount],
                'social' => ['max' => 5, 'current' => $socialCount],
                'image' => ['max' => 5, 'current' => $imageCount],
                'text' => ['max' => 2, 'current' => $textCount],
                'image_url' => true,
            ],
            'premium' => [
                'contact' => ['max' => 1, 'current' => $contactCount],
                'social' => ['max' => 10, 'current' => $socialCount],
                'image' => ['max' => 10, 'current' => $imageCount],
                'text' => ['max' => 5, 'current' => $textCount],
                'image_url' => true,
            ],
        ];

        $planLimits = $limits[$plan] ?? $limits['free'];
        
        return [
            'contact_button' => [
                'available' => $planLimits['contact']['current'] < $planLimits['contact']['max'],
                'remaining' => $planLimits['contact']['max'] - $planLimits['contact']['current'],
            ],
            'social_link' => [
                'available' => $planLimits['social']['current'] < $planLimits['social']['max'],
                'remaining' => $planLimits['social']['max'] - $planLimits['social']['current'],
            ],
            'image' => [
                'available' => $planLimits['image']['current'] < $planLimits['image']['max'],
                'remaining' => $planLimits['image']['max'] - $planLimits['image']['current'],
            ],
            'text_block' => [
                'available' => $planLimits['text']['current'] < $planLimits['text']['max'],
                'remaining' => $planLimits['text']['max'] - $planLimits['text']['current'],
            ],
            'image_url_allowed' => $planLimits['image_url'],
        ];
    }

    // ========== GESTION BANDES ==========
    public function openAddBandModal($type)
    {
        $available = $this->getAvailableBandTypes();
        
        if (!$available[$type]['available']) {
            session()->flash('error', 'Limite atteinte pour ce type de bande.');
            return;
        }

        $this->editingBandId = null;
        $this->newBandType = $type;
        $this->showAddBandModal = true;
    }

    public function editBand($bandId)
    {
        $band = ContentBand::findOrFail($bandId);
        
        if ($band->profile_id !== $this->profile->id) {
            abort(403);
        }

        $this->editingBandId = $bandId;
        $this->newBandType = $band->type;
        
        if ($band->type === 'social_link') {
            $this->newSocialPlatform = $band->data['platform'] ?? '';
            $this->newSocialUrl = $band->data['url'] ?? '';
        } elseif ($band->type === 'image') {
            $this->currentImagePath = $band->data['path'] ?? '';
            $this->newImageLink = $band->data['link'] ?? '';
        } elseif ($band->type === 'text_block') {
            $this->newTextContent = $band->data['text'] ?? '';
        }
        
        $this->showAddBandModal = true;
    }

    public function closeAddBandModal()
    {
        $this->showAddBandModal = false;
        $this->editingBandId = null;
        $this->reset(['newBandType', 'newSocialPlatform', 'newSocialUrl', 'newImage', 'newImageLink', 'newTextContent', 'currentImagePath']);
    }

    public function addSocialLink()
    {
        $this->validate([
            'newSocialPlatform' => 'required|string',
            'newSocialUrl' => 'required|url',
        ]);

        if ($this->editingBandId) {
            $band = ContentBand::findOrFail($this->editingBandId);
            $band->update([
                'data' => [
                    'platform' => $this->newSocialPlatform,
                    'url' => $this->newSocialUrl,
                ],
            ]);
            session()->flash('success', 'Lien modifié!');
        } else {
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'social_link',
                'order' => $maxOrder + 1,
                'data' => [
                    'platform' => $this->newSocialPlatform,
                    'url' => $this->newSocialUrl,
                ],
            ]);
            session()->flash('success', 'Lien ajouté!');
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function addImage()
    {
        $available = $this->getAvailableBandTypes();
        
        $this->validate([
            'newImage' => $this->editingBandId ? 'nullable|image|max:10240' : 'required|image|max:10240',
            'newImageLink' => $available['image_url_allowed'] ? 'nullable|url' : 'nullable',
        ]);

        if (!$available['image_url_allowed'] && $this->newImageLink) {
            session()->flash('error', 'Les liens sur images ne sont pas disponibles avec votre plan.');
            return;
        }

        if ($this->editingBandId) {
            $band = ContentBand::findOrFail($this->editingBandId);
            
            $data = [
                'link' => $available['image_url_allowed'] ? $this->newImageLink : null,
            ];
            
            if ($this->newImage) {
                if (isset($band->data['path'])) {
                    Storage::disk('public')->delete($band->data['path']);
                }
                $data['path'] = $this->newImage->store('band-images', 'public');
            } else {
                $data['path'] = $band->data['path'];
            }
            
            $band->update(['data' => $data]);
            session()->flash('success', 'Image modifiée!');
        } else {
            $path = $this->newImage->store('band-images', 'public');
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;

            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'image',
                'order' => $maxOrder + 1,
                'data' => [
                    'path' => $path,
                    'link' => $available['image_url_allowed'] ? $this->newImageLink : null,
                ],
            ]);
            session()->flash('success', 'Image ajoutée!');
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function addContactButton()
    {
        $maxOrder = $this->profile->contentBands()->max('order') ?? -1;

        ContentBand::create([
            'profile_id' => $this->profile->id,
            'type' => 'contact_button',
            'order' => $maxOrder + 1,
            'data' => [
                'text' => 'Ajouter aux contacts',
            ],
        ]);

        $this->closeAddBandModal();
        $this->loadData();
        session()->flash('success', 'Bouton contact ajouté!');
    }

    public function addTextBlock()
    {
        $this->validate([
            'newTextContent' => 'required|string|max:500',
        ]);

        if ($this->editingBandId) {
            $band = ContentBand::findOrFail($this->editingBandId);
            $band->update([
                'data' => [
                    'text' => $this->newTextContent,
                ],
            ]);
            session()->flash('success', 'Texte modifié!');
        } else {
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;

            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'text_block',
                'order' => $maxOrder + 1,
                'data' => [
                    'text' => $this->newTextContent,
                ],
            ]);
            session()->flash('success', 'Texte ajouté!');
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function deleteBand($bandId)
    {
        $band = ContentBand::findOrFail($bandId);
        
        if ($band->profile_id !== $this->profile->id) {
            abort(403);
        }

        if ($band->type === 'image' && isset($band->data['path'])) {
            Storage::disk('public')->delete($band->data['path']);
        }

        $band->delete();
        $this->loadData();
        session()->flash('success', 'Bande supprimée!');
    }

    public function moveBandUp($bandId)
    {
        $band = ContentBand::findOrFail($bandId);
        if ($band->order > 0) {
            $previousBand = $this->profile->contentBands()->where('order', $band->order - 1)->first();
            if ($previousBand) {
                $band->update(['order' => $band->order - 1]);
                $previousBand->update(['order' => $previousBand->order + 1]);
                $this->loadData();
            }
        }
    }

    public function moveBandDown($bandId)
    {
        $band = ContentBand::findOrFail($bandId);
        $maxOrder = $this->profile->contentBands()->max('order');
        if ($band->order < $maxOrder) {
            $nextBand = $this->profile->contentBands()->where('order', $band->order + 1)->first();
            if ($nextBand) {
                $band->update(['order' => $band->order + 1]);
                $nextBand->update(['order' => $nextBand->order - 1]);
                $this->loadData();
            }
        }
    }

    public function render()
    {
        $availableTypes = $this->getAvailableBandTypes();
        
        return view('livewire.profile.edit-profile', [
            'availableTypes' => $availableTypes,
        ])->layout('layouts.dashboard');
    }
}
