<?php

namespace App\Livewire;

use Livewire\Component;

class Preferences extends Component
{
    public bool $notifyConnectionRequest;
    public bool $notifyConnectionAccepted;

    public function mount()
    {
        $user = auth()->user();
        $this->notifyConnectionRequest = (bool) $user->notify_connection_request;
        $this->notifyConnectionAccepted = (bool) $user->notify_connection_accepted;
    }

    public function updatedNotifyConnectionRequest($value)
    {
        auth()->user()->update(['notify_connection_request' => $value]);
        session()->flash('message', 'Préférences sauvegardées.');
    }

    public function updatedNotifyConnectionAccepted($value)
    {
        auth()->user()->update(['notify_connection_accepted' => $value]);
        session()->flash('message', 'Préférences sauvegardées.');
    }

    public function render()
    {
        return view('livewire.preferences')->layout('layouts.dashboard');
    }
}
