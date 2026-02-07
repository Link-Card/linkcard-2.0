<?php

namespace App\Mail;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CardActivated extends Mailable
{
    use Queueable, SerializesModels;

    public Card $card;

    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function build()
    {
        return $this->subject('Carte NFC activée avec succès! — Link-Card')
                    ->view('emails.card-activated');
    }
}
