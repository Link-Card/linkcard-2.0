<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmail extends Component
{
    public $verified = false;
    public $error = false;
    
    public function mount($id, $hash)
    {
        $user = User::findOrFail($id);
        
        // Vérifier que le hash correspond
        if (!hash_equals((string) $hash, sha1($user->email))) {
            $this->error = true;
            return;
        }
        
        // Marquer l'email comme vérifié
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        
        $this->verified = true;
        
        // Connecter l'utilisateur s'il ne l'est pas déjà
        if (!Auth::check()) {
            Auth::login($user);
        }
    }
    
    public function render()
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.guest');
    }
}
