<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        return view('livewire.dashboard.home')
            ->layout('layouts.dashboard');
    }
}
