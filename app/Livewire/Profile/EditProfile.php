<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\ContentBand;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Traits\WithDeleteConfirmation;
use App\Services\PlanLimitsService;

class EditProfile extends Component
{
    use WithFileUploads, WithDeleteConfirmation;

    public Profile $profile;

    public $full_name, $job_title, $company, $location;
    public $primary_color, $secondary_color, $photo;
    public $email, $phone, $website;
    public $contentBands = [];
    public $customUsername = '';
    public $editingUsername = false;
    public $usernameError = '';
    public $confirmingUsernameChange = false;

    public $showAddBandModal = false;
    public $editingBandId = null;
    public $newBandType = '';
    public $newSocialPlatform = '', $newSocialUrl = '';
    public $newImages = [], $newImageLink = '', $currentImagePaths = [];
    public $newTextContent = '';

    public function mount(Profile $profile)
    {
        if ($profile->user_id !== auth()->id()) abort(403);
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
        $this->customUsername = $this->profile->username;
        $this->contentBands = $this->profile->contentBands()->orderBy('order')->get()->toArray();
    }

    public function updated($property, $value)
    {
        $autoSaveFields = ['full_name', 'job_title', 'company', 'location', 'email', 'phone', 'primary_color', 'secondary_color'];
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

        if (in_array($property, $autoSaveFields) && isset($rules[$property])) {
            $this->validateOnly($property, [$property => $rules[$property]]);
            $this->profile->update([$property => $this->$property]);
            $this->dispatch('auto-saved');
        }

        if ($property === 'photo' && $this->photo) $this->savePhoto();
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

    public function updateUsername()
    {
        $this->usernameError = '';
        $this->confirmingUsernameChange = false;

        // Vérifier que le plan le permet
        $check = $this->profile->canChangeUsername();
        if (!$check['allowed']) {
            $this->usernameError = $check['reason'];
            return;
        }

        // Nettoyer l'input
        $newUsername = strtolower(trim($this->customUsername));

        // Même username
        if ($newUsername === strtolower($this->profile->username)) {
            $this->editingUsername = false;
            return;
        }

        // Validation format
        if (!preg_match('/^[a-z0-9][a-z0-9-]{1,28}[a-z0-9]$/', $newUsername)) {
            $this->usernameError = 'Format invalide. 3-30 caractères : lettres, chiffres, tirets. Ne peut pas commencer ou finir par un tiret.';
            return;
        }

        // Mots réservés
        $reserved = ['admin', 'api', 'app', 'beta', 'blog', 'cdn', 'dashboard', 'dev', 'help',
            'login', 'logout', 'profiles', 'signup', 'support', 'test', 'www', 'v2', 'c',
            'register', 'password', 'reset', 'verify', 'subscription', 'webhook', 'stripe'];
        if (in_array($newUsername, $reserved)) {
            $this->usernameError = 'Ce nom est réservé.';
            return;
        }

        // Unicité
        $exists = \App\Models\Profile::where('username', $newUsername)
            ->where('id', '!=', $this->profile->id)
            ->exists();
        if ($exists) {
            $this->usernameError = 'Ce nom est déjà pris.';
            return;
        }

        // Vérifier si pas un ancien redirect actif d'un autre profil
        $redirectExists = \App\Models\UsernameRedirect::where('old_username', $newUsername)
            ->where('profile_id', '!=', $this->profile->id)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->exists();
        if ($redirectExists) {
            $this->usernameError = 'Ce nom n\'est pas disponible pour le moment.';
            return;
        }

        // Tout est valide → afficher la confirmation
        $this->confirmingUsernameChange = true;
    }

    public function confirmUsernameChange()
    {
        $newUsername = strtolower(trim($this->customUsername));
        $oldUsername = $this->profile->username;

        // Premier changement (code aléatoire d'origine) → redirect PERMANENT
        // Changement suivant (custom → custom) → redirect 90 jours
        $isOriginal = is_null($this->profile->username_changed_at);

        \App\Models\UsernameRedirect::updateOrCreate(
            ['old_username' => strtolower($oldUsername)],
            [
                'profile_id' => $this->profile->id,
                'expires_at' => $isOriginal ? null : now()->addDays(90),
            ]
        );

        // Mettre à jour le username
        $this->profile->update([
            'username' => $newUsername,
            'username_changed_at' => now(),
        ]);

        // Regénérer le QR Code avec la nouvelle URL
        $profileUrl = route('profile.public', $newUsername);
        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(500)->generate($profileUrl));
        $this->profile->update(['qr_code' => $qrCode]);

        $this->profile->refresh();
        $this->editingUsername = false;
        $this->confirmingUsernameChange = false;
        $this->dispatch('auto-saved');
        session()->flash('success', 'URL personnalisée mise à jour !');
    }

    public function cancelUsernameEdit()
    {
        $this->editingUsername = false;
        $this->usernameError = '';
        $this->confirmingUsernameChange = false;
        $this->customUsername = $this->profile->username;
    }

    public function savePhoto()
    {
        $this->validate(['photo' => 'image|max:51200']);
        if ($this->profile->photo_path) Storage::disk('public')->delete($this->profile->photo_path);
        $path = $this->photo->store('profile-photos', 'public');
        $this->profile->update(['photo_path' => $path]);
        $this->profile->refresh();
        $this->photo = null;
        $this->dispatch('auto-saved');
    }

    public function saveAndReturn()
    {
        $this->profile->update(['website' => route('profile.public', $this->profile->username)]);
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
            ContentBand::where('id', $id)->where('profile_id', $this->profile->id)->update(['order' => $index]);
        }
        $this->loadData();
    }

    public function getTotalImageCount($visibleOnly = true)
    {
        $count = 0;
        foreach ($this->contentBands as $band) {
            if ($band['type'] === 'image') {
                if ($visibleOnly && ($band['is_hidden'] ?? false)) continue;
                $images = $band['data']['images'] ?? [];
                $count += empty($images) && isset($band['data']['path']) ? 1 : count($images);
            }
        }
        return $count;
    }

    public function getAvailableBandTypes()
    {
        $user = auth()->user();
        $plan = $user->plan ?? 'free';
        $limits = PlanLimitsService::getLimits($plan, $user);
        
        $visibleBands = collect($this->contentBands)->filter(fn($b) => !($b['is_hidden'] ?? false));
        
        $contactCount = $visibleBands->where('type', 'contact_button')->count();
        $socialCount = $visibleBands->where('type', 'social_link')->count();
        $totalImages = $this->getTotalImageCount(true);
        $textCount = $visibleBands->where('type', 'text_block')->count();

        return [
            'contact_button' => ['available' => $contactCount < 1, 'remaining' => 1 - $contactCount],
            'social_link' => ['available' => $socialCount < $limits['social_links'], 'remaining' => $limits['social_links'] - $socialCount],
            'image' => ['available' => $totalImages < $limits['images'], 'remaining' => $limits['images'] - $totalImages, 'max_per_band' => min(2, $limits['images'] - $totalImages)],
            'text_block' => ['available' => $textCount < $limits['text_blocks'], 'remaining' => $limits['text_blocks'] - $textCount],
            'image_url_allowed' => $plan !== 'free' || PlanLimitsService::isSuperAdmin($user),
        ];
    }

    public function getHiddenBandsCount()
    {
        return collect($this->contentBands)->filter(fn($b) => $b['is_hidden'] ?? false)->count();
    }

    public function getRequiredPlan()
    {
        return PlanLimitsService::getRequiredPlanForAll($this->profile);
    }

    // ========== BAND MODALS ==========

    public function openAddBandModal($type = null)
    {
        $this->editingBandId = null;
        $this->reset(['newBandType', 'newSocialPlatform', 'newSocialUrl', 'newImages', 'newImageLink', 'newTextContent', 'currentImagePaths']);
        if ($type) {
            $available = $this->getAvailableBandTypes();
            if (isset($available[$type]) && !$available[$type]['available']) {
                session()->flash('error', 'Limite atteinte pour ce type de bande. Passez à un forfait supérieur pour en ajouter plus.');
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
            session()->flash('error', 'Limite atteinte pour ce type de bande. Passez à un forfait supérieur pour en ajouter plus.');
            return;
        }
        $this->newBandType = $type;
    }

    public function editBand($bandId)
    {
        $band = ContentBand::findOrFail($bandId);
        if ($band->profile_id !== $this->profile->id) abort(403);
        
        if ($band->is_hidden) {
            session()->flash('error', 'Cette bande est masquée. Passez à un forfait supérieur pour la débloquer ou supprimez-la.');
            return;
        }

        $this->editingBandId = $bandId;
        $this->newBandType = $band->type;

        if ($band->type === 'social_link') {
            $this->newSocialPlatform = $band->data['platform'] ?? '';
            $this->newSocialUrl = $band->data['url'] ?? '';
        } elseif ($band->type === 'image') {
            $this->currentImagePaths = isset($band->data['images']) ? array_column($band->data['images'], 'path') : (isset($band->data['path']) ? [$band->data['path']] : []);
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

    // ========== DELETE (using trait) ==========

    public function confirmDelete($bandId)
    {
        $band = ContentBand::find($bandId);
        if (!$band || $band->profile_id !== $this->profile->id) return;

        $name = match($band->type) {
            'contact_button' => 'Ajouter aux contacts',
            'social_link' => $band->data['platform'] ?? 'Lien social',
            'image' => isset($band->data['images']) && count($band->data['images']) > 1 ? 'Images ('.count($band->data['images']).')' : 'Image',
            'text_block' => 'Bloc texte',
            default => 'Bande'
        };

        $this->confirmDeleteItem($bandId, $name, 'cette bande');
    }

    public function deleteConfirmed()
    {
        if (!$this->deletingItemId) return;

        $band = ContentBand::findOrFail($this->deletingItemId);
        if ($band->profile_id !== $this->profile->id) abort(403);

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
        $this->cancelDelete();
        $this->loadData();
    }

    // ========== ADD BANDS ==========

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
        $this->validate(['newSocialPlatform' => 'required|string', 'newSocialUrl' => 'required|url']);

        if ($this->editingBandId) {
            ContentBand::findOrFail($this->editingBandId)->update(['data' => ['platform' => $this->newSocialPlatform, 'url' => $this->newSocialUrl]]);
        } else {
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create([
                'profile_id' => $this->profile->id,
                'type' => 'social_link',
                'order' => $maxOrder + 1,
                'data' => ['platform' => $this->newSocialPlatform, 'url' => $this->newSocialUrl],
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
            $images = $band->data['images'] ?? (isset($band->data['path']) ? [['path' => $band->data['path'], 'link' => $band->data['link'] ?? '']] : []);

            if (!empty($this->newImages)) {
                foreach ($images as $img) { if (isset($img['path'])) Storage::disk('public')->delete($img['path']); }
                $images = [];
                foreach ($this->newImages as $file) {
                    $images[] = ['path' => $file->store('band-images', 'public'), 'link' => $available['image_url_allowed'] ? $this->newImageLink : ''];
                }
            }
            $band->update(['data' => ['images' => $images]]);
        } else {
            $images = [];
            foreach ($this->newImages as $file) {
                $images[] = ['path' => $file->store('band-images', 'public'), 'link' => $available['image_url_allowed'] ? $this->newImageLink : ''];
            }
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create(['profile_id' => $this->profile->id, 'type' => 'image', 'order' => $maxOrder + 1, 'data' => ['images' => $images]]);
        }
        $this->closeAddBandModal();
        $this->loadData();
    }

    public function addTextBlock()
    {
        $this->validate(['newTextContent' => 'required|string|max:500']);

        if ($this->editingBandId) {
            ContentBand::findOrFail($this->editingBandId)->update(['data' => ['text' => $this->newTextContent]]);
        } else {
            $maxOrder = $this->profile->contentBands()->max('order') ?? -1;
            ContentBand::create(['profile_id' => $this->profile->id, 'type' => 'text_block', 'order' => $maxOrder + 1, 'data' => ['text' => $this->newTextContent]]);
        }
        $this->closeAddBandModal();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.profile.edit-profile', [
            'availableTypes' => $this->getAvailableBandTypes(),
            'headerTextColor' => $this->getHeaderTextColor(),
            'hiddenCount' => $this->getHiddenBandsCount(),
            'userPlan' => auth()->user()->plan ?? 'free',
            'requiredPlan' => $this->getRequiredPlan(),
        ])->layout('layouts.dashboard');
    }
}
