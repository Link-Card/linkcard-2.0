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

    // Header fields
    public $full_name;
    public $job_title;
    public $company;
    public $location;
    public $primary_color;
    public $secondary_color;
    public $photo;

    // Contact info
    public $email;
    public $phone;
    public $website;

    // Content bands
    public $contentBands = [];

    // Modal state
    public $showAddBandModal = false;
    public $editingBandId = null;
    public $newBandType = '';

    // Delete confirmation modal
    public $showDeleteModal = false;
    public $deletingBandId = null;
    public $deletingBandName = '';

    // Band form fields
    public $newSocialPlatform = '';
    public $newSocialUrl = '';
    public $newImages = [];
    public $newImageLink = '';
    public $currentImagePaths = [];
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
        $this->full_name = $this->profile->full_name;
        $this->job_title = $this->profile->job_title;
        $this->company = $this->profile->company;
        $this->location = $this->profile->location;
        $this->primary_color = $this->profile->primary_color ?? '#2D7A4F';
        $this->secondary_color = $this->profile->secondary_color ?? '#1a5c3a';
        $this->email = $this->profile->email;
        $this->phone = $this->profile->phone;
        $this->website = $this->profile->website;

        $this->contentBands = $this->profile->contentBands()->orderBy('order')->get()->toArray();
    }

    public function updated($property, $value)
    {
        $autoSaveFields = [
            'full_name', 'job_title', 'company', 'location',
            'email', 'phone', 'primary_color', 'secondary_color',
        ];

        $rules = [
            'full_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
        ];

        if (in_array($property, $autoSaveFields)) {
            if (isset($rules[$property])) {
                $this->validateOnly($property, [$property => $rules[$property]]);
                $this->profile->update([$property => $this->$property]);
                $this->dispatch('auto-saved');
            }
        }

        if ($property === 'photo' && $this->photo) {
            $this->savePhoto();
        }
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

    public function savePhoto()
    {
        $this->validate(['photo' => 'image|max:15360']);

        if ($this->profile->photo_path) {
            Storage::disk('public')->delete($this->profile->photo_path);
        }

        $path = $this->photo->store('profile-photos', 'public');
        $this->profile->update(['photo_path' => $path]);
        $this->profile->refresh();
        $this->photo = null;
        $this->dispatch('auto-saved');
    }

    public function saveAndReturn()
    {
        $profileUrl = route('profile.public', $this->profile->username);
        $this->profile->update(['website' => $profileUrl]);

        return redirect()->route('profile.index');
    }

    public function getHeaderTextColor()
    {
        $hex = ltrim($this->primary_color ?? '#2D7A4F', '#');
        if (strlen($hex) !== 6) return '#FFFFFF';
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        return $luminance > 0.6 ? '#2C2A27' : '#FFFFFF';
    }

    public function reorderBands($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            ContentBand::where('id', $id)
                ->where('profile_id', $this->profile->id)
                ->update(['order' => $index]);
        }
        $this->loadData();
    }

    public function getTotalImageCount()
    {
        $count = 0;
        foreach ($this->contentBands as $band) {
            if ($band['type'] === 'image') {
                $images = $band['data']['images'] ?? [];
                if (empty($images) && isset($band['data']['path'])) {
                    $count += 1;
                } else {
                    $count += count($images);
                }
            }
        }
        return $count;
    }

    public function getAvailableBandTypes()
    {
        $user = auth()->user();
        $plan = $user->plan ?? 'free';

        $contactCount = collect($this->contentBands)->where('type', 'contact_button')->count();
        $socialCount = collect($this->contentBands)->where('type', 'social_link')->count();
        $totalImages = $this->getTotalImageCount();
        $textCount = collect($this->contentBands)->where('type', 'text_block')->count();

        $limits = [
            'free' => ['contact' => 1, 'social' => 2, 'image' => 2, 'text' => 1, 'image_url' => false],
            'pro' => ['contact' => 1, 'social' => 5, 'image' => 5, 'text' => 2, 'image_url' => true],
            'premium' => ['contact' => 1, 'social' => 10, 'image' => 10, 'text' => 5, 'image_url' => true],
        ];

        $planLimits = $limits[$plan] ?? $limits['free'];

        return [
            'contact_button' => [
                'available' => $contactCount < $planLimits['contact'],
                'remaining' => $planLimits['contact'] - $contactCount,
            ],
            'social_link' => [
                'available' => $socialCount < $planLimits['social'],
                'remaining' => $planLimits['social'] - $socialCount,
            ],
            'image' => [
                'available' => $totalImages < $planLimits['image'],
                'remaining' => $planLimits['image'] - $totalImages,
                'max_per_band' => min(2, $planLimits['image'] - $totalImages),
            ],
            'text_block' => [
                'available' => $textCount < $planLimits['text'],
                'remaining' => $planLimits['text'] - $textCount,
            ],
            'image_url_allowed' => $planLimits['image_url'],
        ];
    }

    public function openAddBandModal($type = null)
    {
        $this->editingBandId = null;
        $this->reset(['newBandType', 'newSocialPlatform', 'newSocialUrl', 'newImages', 'newImageLink', 'newTextContent', 'currentImagePaths']);

        if ($type) {
            $available = $this->getAvailableBandTypes();
            if (isset($available[$type]) && !$available[$type]['available']) {
                session()->flash('error', 'Limite atteinte pour ce type de bande.');
                return;
            }
            $this->newBandType = $type;
        }

        $this->showAddBandModal = true;
    }

    public function selectBandType($type)
    {
        $available = $this->getAvailableBandTypes();
        if (isset($available[$type]) && !$available[$type]['available']) {
            session()->flash('error', 'Limite atteinte pour ce type de bande.');
            return;
        }
        $this->newBandType = $type;
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
            if (isset($band->data['images'])) {
                $this->currentImagePaths = array_column($band->data['images'], 'path');
            } elseif (isset($band->data['path'])) {
                $this->currentImagePaths = [$band->data['path']];
            }
            $this->newImageLink = $band->data['link'] ?? ($band->data['images'][0]['link'] ?? '');
        } elseif ($band->type === 'text_block') {
            $this->newTextContent = $band->data['text'] ?? '';
        }

        $this->showAddBandModal = true;
    }

    public function closeAddBandModal()
    {
        $this->showAddBandModal = false;
        $this->editingBandId = null;
        $this->reset(['newBandType', 'newSocialPlatform', 'newSocialUrl', 'newImages', 'newImageLink', 'newTextContent', 'currentImagePaths']);
    }

    // ========== DELETE CONFIRMATION ==========

    public function confirmDelete($bandId)
    {
        $band = ContentBand::find($bandId);
        if (!$band || $band->profile_id !== $this->profile->id) {
            return;
        }

        $this->deletingBandId = $bandId;

        // Déterminer le nom à afficher
        if ($band->type === 'contact_button') {
            $this->deletingBandName = 'Ajouter aux contacts';
        } elseif ($band->type === 'social_link') {
            $this->deletingBandName = $band->data['platform'] ?? 'Lien social';
        } elseif ($band->type === 'image') {
            $imgCount = isset($band->data['images']) ? count($band->data['images']) : 1;
            $this->deletingBandName = $imgCount > 1 ? "Images ($imgCount)" : 'Image';
        } elseif ($band->type === 'text_block') {
            $this->deletingBandName = 'Bloc texte';
        } else {
            $this->deletingBandName = 'Bande';
        }

        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deletingBandId = null;
        $this->deletingBandName = '';
    }

    public function deleteBand($bandId = null)
    {
        $id = $bandId ?? $this->deletingBandId;
        if (!$id) return;

        $band = ContentBand::findOrFail($id);

        if ($band->profile_id !== $this->profile->id) {
            abort(403);
        }

        if ($band->type === 'image') {
            $images = $band->data['images'] ?? [];
            if (empty($images) && isset($band->data['path'])) {
                Storage::disk('public')->delete($band->data['path']);
            } else {
                foreach ($images as $img) {
                    if (isset($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                    }
                }
            }
        }

        $band->delete();
        $this->cancelDelete();
        $this->loadData();
    }

    public function addContactButton()
    {
        $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
        ContentBand::create([
            'profile_id' => $this->profile->id,
            'type' => 'contact_button',
            'order' => $maxOrder + 1,
            'data' => ['text' => 'Ajouter aux contacts'],
        ]);
        $this->closeAddBandModal();
        $this->loadData();
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
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function addImage()
    {
        $available = $this->getAvailableBandTypes();

        $this->validate([
            'newImages' => $this->editingBandId ? 'nullable' : 'required|array|min:1|max:2',
            'newImages.*' => 'image|max:51200',
        ]);

        if ($this->editingBandId) {
            $band = ContentBand::findOrFail($this->editingBandId);
            $images = $band->data['images'] ?? [];

            if (empty($images) && isset($band->data['path'])) {
                $images = [['path' => $band->data['path'], 'link' => $band->data['link'] ?? '']];
            }

            if (!empty($this->newImages)) {
                foreach ($images as $img) {
                    if (isset($img['path'])) {
                        Storage::disk('public')->delete($img['path']);
                    }
                }
                $images = [];
                foreach ($this->newImages as $file) {
                    $images[] = [
                        'path' => $file->store('band-images', 'public'),
                        'link' => $available['image_url_allowed'] ? $this->newImageLink : '',
                    ];
                }
            }

            $band->update(['data' => ['images' => $images]]);
        } else {
            $images = [];
            foreach ($this->newImages as $file) {
                $images[] = [
                    'path' => $file->store('band-images', 'public'),
                    'link' => $available['image_url_allowed'] ? $this->newImageLink : '',
                ];
            }

            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'image',
                'order' => $maxOrder + 1,
                'data' => ['images' => $images],
            ]);
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function addTextBlock()
    {
        $this->validate([
            'newTextContent' => 'required|string|max:500',
        ]);

        if ($this->editingBandId) {
            $band = ContentBand::findOrFail($this->editingBandId);
            $band->update([
                'data' => ['text' => $this->newTextContent],
            ]);
        } else {
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'text_block',
                'order' => $maxOrder + 1,
                'data' => ['text' => $this->newTextContent],
            ]);
        }

        $this->closeAddBandModal();
        $this->loadData();
    }

    public function render()
    {
        $availableTypes = $this->getAvailableBandTypes();
        $headerTextColor = $this->getHeaderTextColor();

        return view('livewire.profile.edit-profile', [
            'availableTypes' => $availableTypes,
            'headerTextColor' => $headerTextColor,
        ])->layout('layouts.dashboard');
    }
}
