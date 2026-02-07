<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use App\Services\ConnectionService;
use App\Services\ReferralService;

class Index extends Component
{
    public $confirmRemoveId = null;

    public function acceptRequest($connectionId)
    {
        $result = ConnectionService::acceptRequest($connectionId, auth()->id());
        session()->flash('message', $result['message']);
    }

    public function declineRequest($connectionId)
    {
        $result = ConnectionService::declineRequest($connectionId, auth()->id());
        session()->flash('message', $result['message']);
    }

    public function cancelRequest($connectionId)
    {
        $result = ConnectionService::cancelRequest($connectionId, auth()->id());
        session()->flash('message', $result['message']);
    }

    public function confirmRemove($connectionId)
    {
        $this->confirmRemoveId = $connectionId;
    }

    public function cancelRemove()
    {
        $this->confirmRemoveId = null;
    }

    public function removeConnection()
    {
        if (!$this->confirmRemoveId) return;

        $result = ConnectionService::removeConnection($this->confirmRemoveId, auth()->id());
        $this->confirmRemoveId = null;
        session()->flash('message', $result['message']);
    }

    public function render()
    {
        $userId = auth()->id();

        return view('livewire.connections.index', [
            'pendingReceived' => ConnectionService::getPendingReceived($userId),
            'pendingSent' => ConnectionService::getPendingSent($userId),
            'contacts' => ConnectionService::getContacts($userId),
            'contactsCount' => ConnectionService::getContactsCount($userId),
            'referralProgress' => ReferralService::getProgress($userId),
        ])->layout('layouts.dashboard');
    }
}
