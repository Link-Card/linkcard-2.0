<?php

namespace App\Mail;

use App\Models\CardOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public CardOrder $order;

    public function __construct(CardOrder $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Commande ' . $this->order->order_number . ' confirmée — Link-Card')
                    ->view('emails.order-confirmed');
    }
}
