<?php

namespace App\Livewire\Auth;

use App\Services\ConnectionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $ref = '';
    public $action = '';
    
    public function mount()
    {
        $this->ref = request()->query('ref', '');
        $this->action = request()->query('action', '');
    }
    
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
        
        $key = Str::lower($this->email).'|'.request()->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Trop de tentatives. Réessayez dans {$seconds} secondes.");
            return;
        }
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();
            
            // Redirection carte en attente de confirmation
            if ($cardCode = session()->pull('pending_card_confirm')) {
                return redirect()->route('card.confirm.show', $cardCode);
            }
            
            // Auto-connect si ?action=connect et ?ref=username
            if ($this->action === 'connect' && $this->ref) {
                $profile = \App\Models\Profile::where('username', $this->ref)->first();
                if ($profile && $profile->user_id !== Auth::id()) {
                    $result = ConnectionService::sendRequest(Auth::id(), $profile->user_id);
                    if ($result['success']) {
                        session()->flash('connection-sent', $result['message']);
                    }
                }
                // Rediriger vers le profil après connexion
                return redirect()->route('profile.public', $this->ref);
            }
            
            return redirect()->intended('dashboard');
        }
        
        RateLimiter::hit($key, 60);
        $this->addError('email', 'Les identifiants fournis sont incorrects.');
    }
    
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }
}
