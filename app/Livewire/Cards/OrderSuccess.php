<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use App\Models\CardOrder;
use App\Models\Card;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;

class OrderSuccess extends Component
{
    public $order;

    public function mount(CardOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Verify payment and update status
        if ($order->status === 'pending' && request()->has('session_id')) {
            try {
                $stripe = new \Stripe\StripeClient(config('cashier.secret'));
                $session = $stripe->checkout->sessions->retrieve(request('session_id'));

                if ($session->payment_status === 'paid') {
                    $order->update([
                        'status' => 'paid',
                        'stripe_payment_id' => $session->payment_intent,
                    ]);

                    // Auto-create Card entries from items
                    $this->createCardsFromOrder($order);

                    Log::info('Card order paid + cards created', [
                        'order_id' => $order->id,
                    ]);

                    // Send confirmation email
                    try {
                        Mail::to($order->user->email)->send(new OrderConfirmed($order));
                    } catch (\Exception $mailError) {
                        Log::error('Order confirmation email failed', ['error' => $mailError->getMessage()]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error verifying payment', ['error' => $e->getMessage()]);
            }
        }

        $this->order = $order->fresh();
    }

    private function createCardsFromOrder(CardOrder $order)
    {
        if (!$order->items) return;

        foreach ($order->items as $item) {
            // Check if card with this code already exists
            if (Card::where('card_code', $item['card_code'])->exists()) continue;

            Card::create([
                'card_code' => $item['card_code'],
                'user_id' => $order->user_id,
                'profile_id' => $item['profile_id'],
                'is_active' => true,
                'order_id' => $order->id,
                'programmed_at' => null,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.cards.order-success')
            ->layout('layouts.dashboard');
    }
}
