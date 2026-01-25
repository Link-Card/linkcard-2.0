<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    
    protected $messages = [
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
        'password.required' => 'Le mot de passe est requis.',
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function login()
    {
        $this->validate();
        
        // Rate limiting key basé sur email
        $key = Str::lower($this->email).'|'.request()->ip();
        
        // Vérifier si trop de tentatives
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Trop de tentatives. Réessayez dans {$seconds} secondes.");
            return;
        }
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Réinitialiser le compteur en cas de succès
            RateLimiter::clear($key);
            session()->regenerate();
            return redirect()->intended('dashboard');
        }
        
        // Incrémenter le compteur d'échecs
        RateLimiter::hit($key, 60); // 60 secondes
        
        $this->addError('email', 'Les identifiants fournis sont incorrects.');
    }
    
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }
}
