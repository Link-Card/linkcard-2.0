<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectionAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public User $accepter;
    public User $requester;
    public $accepterProfile;

    public function __construct(User $accepter, User $requester)
    {
        $this->accepter = $accepter;
        $this->requester = $requester;
        $this->accepterProfile = $accepter->profiles()->first();
    }

    public function build()
    {
        $name = $this->accepterProfile->full_name ?? $this->accepter->name;
        return $this->subject($name . ' a accepté votre demande — Link-Card')
                    ->view('emails.connection-accepted');
    }
}
