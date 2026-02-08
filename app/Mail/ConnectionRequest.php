<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectionRequest extends Mailable
{
    use Queueable, SerializesModels;

    public User $sender;
    public User $receiver;
    public $senderProfile;

    public function __construct(User $sender, User $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->senderProfile = $sender->profiles()->first();
    }

    public function build()
    {
        return $this->subject($this->sender->name . ' veut se connecter — Link-Card')
                    ->view('emails.connection-request');
    }
}
