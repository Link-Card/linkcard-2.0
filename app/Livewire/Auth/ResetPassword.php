<?php

namespace App\Livewire\Auth;

use App\Rules\StrongPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public $token;
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => ['required', 'confirmed', new StrongPassword()],
        ];
    }
    
    protected $messages = [
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
        'password.required' => 'Le mot de passe est requis.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];
    
    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function resetPassword()
    {
        $this->validate();
        
        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                
                $user->save();
                
                event(new PasswordReset($user));
            }
        );
        
        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Votre mot de passe a été réinitialisé avec succès!');
            return redirect()->route('login');
        }
        
        $this->addError('email', 'Ce lien de réinitialisation est invalide ou expiré.');
    }
    
    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('layouts.guest');
    }
}
