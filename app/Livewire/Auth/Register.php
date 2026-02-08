<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Rules\StrongPassword;
use App\Services\ConnectionService;
use App\Services\ReferralService;
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
    public $ref = '';
    public $action = '';
    
    public function mount()
    {
        $this->ref = request()->query('ref', '');
        $this->action = request()->query('action', '');
    }
    
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
        
        // Générer un referral_code unique
        $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        do {
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
        } while (User::where('referral_code', $code)->exists());
        
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'plan' => 'free',
            'referral_code' => $code,
        ]);
        
        // Tracker le referral si ?ref= présent
        if ($this->ref) {
            ReferralService::trackReferral($this->ref, $user->id);
        }
        
        // Envoyer l'email de vérification
        Mail::to($user->email)->send(new VerifyEmail($user));
        
        Auth::login($user);
        
        // Auto-connect si ?action=connect et ?ref=username
        if ($this->action === 'connect' && $this->ref) {
            $profile = \App\Models\Profile::where('username', $this->ref)->first();
            if ($profile && $profile->user_id !== $user->id) {
                ConnectionService::sendRequest($user->id, $profile->user_id);
                session()->flash('connection-sent', 'Demande de connexion envoyée !');
            }
        }
        
        session()->flash('verification-sent', 'Un email de vérification a été envoyé à votre adresse.');
        
        return redirect()->route('verification.notice');
    }
    
    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.guest');
    }
}
