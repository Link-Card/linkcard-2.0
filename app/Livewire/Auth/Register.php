<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', new StrongPassword()],
        ];
    }
    
    protected $messages = [
        'name.required' => 'Le nom est requis.',
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'password.required' => 'Le mot de passe est requis.',
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
        
        // Envoyer l'email de vérification
        Mail::to($user->email)->send(new VerifyEmail($user));
        
        // Email de bienvenue envoyé 24h après via commande planifiée
        
        Auth::login($user);
        
        session()->flash('verification-sent', 'Un email de vérification a été envoyé à votre adresse.');
        
        return redirect()->route('verification.notice');
    }
    
    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }
}
