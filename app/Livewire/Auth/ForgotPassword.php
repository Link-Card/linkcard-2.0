<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
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
        
        $status = Password::sendResetLink(
            ['email' => $this->email]
        );
        
        if ($status === Password::RESET_LINK_SENT) {
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
