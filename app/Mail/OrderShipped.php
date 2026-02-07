<?php

namespace App\Mail;

use App\Models\CardOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public CardOrder $order;

    public function __construct(CardOrder $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Votre carte NFC est en route! — Link-Card')
                    ->view('emails.order-shipped');
    }
}
