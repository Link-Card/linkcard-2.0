<?php

namespace App\Livewire\Auth;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VerifyEmailNotice extends Component
{
    public $resent = false;
    public $code = '';
    public $codeError = '';
    
    public function verifyCode()
    {
        $this->codeError = '';
        $user = auth()->user();
        
        if (!$user) return;
        
        $code = trim($this->code);
        
        if (strlen($code) !== 6) {
            $this->codeError = 'Le code doit contenir 6 chiffres.';
            return;
        }
        
        if (!$user->verification_code) {
            $this->codeError = 'Aucun code en attente. Renvoyez un nouveau code.';
            return;
        }
        
        if ($user->verification_code_expires_at && now()->gt($user->verification_code_expires_at)) {
            $this->codeError = 'Ce code a expiré. Renvoyez un nouveau code.';
            $user->update(['verification_code' => null, 'verification_code_expires_at' => null]);
            return;
        }
        
        if ($code !== $user->verification_code) {
            $this->codeError = 'Code incorrect. Vérifiez et réessayez.';
            return;
        }
        
        // Code is valid — mark email as verified
        $user->markEmailAsVerified();
        $user->update(['verification_code' => null, 'verification_code_expires_at' => null]);
        
        return redirect()->intended('/dashboard');
    }
    
    public function resendVerificationEmail()
    {
        $user = auth()->user();
        
        if ($user && !$user->hasVerifiedEmail()) {
            Mail::to($user->email)->send(new VerifyEmail($user));
            $this->resent = true;
            $this->code = '';
            $this->codeError = '';
        }
    }
    
    public function render()
    {
        return view('livewire.auth.verify-email-notice')
            ->layout('layouts.guest');
    }
}
