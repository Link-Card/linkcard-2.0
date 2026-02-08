<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProfileReport;
use App\Models\Profile;

class ReportProfile extends Component
{
    public $profileId;
    public bool $showModal = false;
    public string $reason = '';
    public string $details = '';
    public bool $submitted = false;

    protected $rules = [
        'reason' => 'required|string|in:explicit_content,illegal_content,harassment,spam,impersonation,hate_speech,dangerous_links,other',
        'details' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'reason.required' => 'Veuillez sélectionner une raison.',
    ];

    public function openModal()
    {
        $this->reset(['reason', 'details', 'submitted']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function submit()
    {
        $this->validate();

        ProfileReport::create([
            'profile_id' => $this->profileId,
            'reporter_id' => auth()->id(), // null if not logged in
            'reason' => $this->reason,
            'details' => $this->details,
            'status' => 'pending',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.report-profile');
    }
}
