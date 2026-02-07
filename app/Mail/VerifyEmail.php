<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationCode;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->verificationCode = $this->generateCode($user);
    }

    protected function generateCode(User $user): string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'verification_code' => $code,
            'verification_code_expires_at' => now()->addMinutes(30),
        ]);
        
        return $code;
    }

    public function build()
    {
        return $this->subject('Votre code de vérification Link-Card : ' . $this->verificationCode)
                    ->view('emails.verify-email');
    }
}
