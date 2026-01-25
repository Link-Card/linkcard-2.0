<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];
    
    protected $messages = [
        'name.required' => 'Le nom est requis.',
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'password.required' => 'Le mot de passe est requis.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function register()
    {
        $this->validate();
        
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'subscription_plan' => 'free',
        ]);
        
        event(new Registered($user));
        
        Auth::login($user);
        
        return redirect()->route('dashboard');
    }
    
    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }
}
