<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\CardOrder;
use Illuminate\Support\Facades\Log;

class OrderSuccess extends Component
{
    public $order;

    public function mount(CardOrder $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Update status if still pending (payment confirmed by redirect)
        if ($order->status === 'pending' && request()->has('session_id')) {
            try {
                $stripe = new \Stripe\StripeClient(config('cashier.secret'));
                $session = $stripe->checkout->sessions->retrieve(request('session_id'));

                if ($session->payment_status === 'paid') {
                    $order->update([
                        'status' => 'paid',
                        'stripe_payment_id' => $session->payment_intent,
                    ]);

                    Log::info('Card order paid', [
                        'order_id' => $order->id,
                        'payment_intent' => $session->payment_intent,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error verifying payment', ['error' => $e->getMessage()]);
            }
        }

        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.cards.order-success')
            ->layout('layouts.dashboard');
    }
}
