<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
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
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended('dashboard');
        }
        
        $this->addError('email', 'Les identifiants fournis sont incorrects.');
    }
    
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest');
    }
}
