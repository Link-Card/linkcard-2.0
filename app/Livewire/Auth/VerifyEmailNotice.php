<?php

namespace App\Livewire\Auth;

use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VerifyEmailNotice extends Component
{
    public $resent = false;
    
    public function checkVerification()
    {
        $user = auth()->user();
        if ($user && $user->fresh()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }
    }
    
    public function resendVerificationEmail()
    {
        $user = auth()->user();
        
        if ($user && !$user->hasVerifiedEmail()) {
            Mail::to($user->email)->send(new VerifyEmail($user));
            $this->resent = true;
        }
    }
    
    public function render()
    {
        return view('livewire.auth.verify-email-notice')
            ->layout('layouts.guest');
    }
}
