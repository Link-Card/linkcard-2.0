<?php

namespace App\Mail;

use App\Models\CardOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(CardOrder $order)
    {
        $this->order = $order->load('user');
    }

    public function build()
    {
        $orderNumber = 'LC-' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT);
        
        return $this->subject("🔔 Nouvelle commande {$orderNumber} — Link-Card")
                    ->view('emails.new-order-admin');
    }
}
