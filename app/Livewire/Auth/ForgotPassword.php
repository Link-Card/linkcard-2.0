<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email = '';
    public $emailSent = false;
    
    protected $rules = [
        'email' => 'required|email',
    ];
    
    protected $messages = [
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function sendResetLink()
    {
        $this->validate();
        
        // Rate limiting key basé sur email
        $key = 'password-reset:'.Str::lower($this->email);
        
        // Vérifier si trop de tentatives (max 3 par heure)
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $minutes = ceil(RateLimiter::availableIn($key) / 60);
            $this->addError('email', "Trop de tentatives. Réessayez dans {$minutes} minutes.");
            return;
        }
        
        $status = Password::sendResetLink(
            ['email' => $this->email]
        );
        
        if ($status === Password::RESET_LINK_SENT) {
            // Incrémenter le compteur (3600 secondes = 1 heure)
            RateLimiter::hit($key, 3600);
            
            $this->emailSent = true;
            $this->email = '';
        } else {
            $this->addError('email', 'Nous ne trouvons pas d\'utilisateur avec cette adresse email.');
        }
    }
    
    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.guest');
    }
}
