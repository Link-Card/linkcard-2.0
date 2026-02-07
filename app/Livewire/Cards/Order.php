<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CardOrder;
use App\Models\Card;
use Illuminate\Support\Facades\Log;

class Order extends Component
{
    use WithFileUploads;

    // Cart items: [['profile_id' => X, 'quantity' => Y, 'design_type' => 'standard|custom'], ...]
    public array $items = [];
    public $logoFile = null;

    // Shipping address
    public string $shippingName = '';
    public string $shippingStreet = '';
    public string $shippingCity = '';
    public string $shippingProvince = 'QC';
    public string $shippingPostalCode = '';
    public string $shippingPhone = '';

    // UI state
    public int $step = 1; // 1=panier, 2=adresse, 3=résumé

    protected $messages = [
        'shippingName.required' => 'Le nom est requis.',
        'shippingStreet.required' => 'L\'adresse est requise.',
        'shippingCity.required' => 'La ville est requise.',
        'shippingPostalCode.required' => 'Le code postal est requis.',
        'shippingPhone.required' => 'Le téléphone est requis.',
        'logoFile.image' => 'Le fichier doit être une image.',
        'logoFile.max' => 'Le logo ne doit pas dépasser 15 Mo.',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->shippingName = $user->name ?? '';

        // Start with one item if user has profiles
        $profiles = $user->profiles;
        if ($profiles->count() > 0) {
            $this->items = [[
                'profile_id' => $profiles->first()->id,
                'quantity' => 1,
                'design_type' => 'standard',
            ]];
        }
    }

    public function addItem()
    {
        $profiles = auth()->user()->profiles;
        if ($profiles->count() === 0) return;

        $this->items[] = [
            'profile_id' => $profiles->first()->id,
            'quantity' => 1,
            'design_type' => 'standard',
        ];
    }

    public function removeItem($index)
    {
        if (count($this->items) <= 1) return;
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function incrementItem($index)
    {
        if (isset($this->items[$index]) && $this->items[$index]['quantity'] < 10) {
            $this->items[$index]['quantity']++;
        }
    }

    public function decrementItem($index)
    {
        if (isset($this->items[$index]) && $this->items[$index]['quantity'] > 1) {
            $this->items[$index]['quantity']--;
        }
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            if (empty($this->items)) {
                session()->flash('error', 'Ajoutez au moins une carte.');
                return;
            }
            // Check if any custom needs logo
            $hasCustom = collect($this->items)->contains('design_type', 'custom');
            if ($hasCustom && !$this->logoFile) {
                $this->addError('logoFile', 'Le logo est requis pour le design personnalisé.');
                return;
            }
            $this->step = 2;
        } elseif ($this->step === 2) {
            $this->validate([
                'shippingName' => 'required|string|max:255',
                'shippingStreet' => 'required|string|max:255',
                'shippingCity' => 'required|string|max:255',
                'shippingProvince' => 'required|string|max:2',
                'shippingPostalCode' => 'required|string|max:10',
                'shippingPhone' => 'required|string|max:20',
            ]);
            $this->step = 3;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function getTotalQuantityProperty(): int
    {
        return collect($this->items)->sum('quantity');
    }

    public function getUnitPriceProperty(): int
    {
        return CardOrder::getPriceForUser(auth()->user());
    }

    public function getTotalPriceProperty(): int
    {
        return $this->unitPrice * $this->totalQuantity;
    }

    public function getDisplayUnitPriceProperty(): string
    {
        return number_format($this->unitPrice / 100, 2);
    }

    public function getDisplayTotalPriceProperty(): string
    {
        return number_format($this->totalPrice / 100, 2);
    }

    public function getHasDiscountProperty(): bool
    {
        return in_array(auth()->user()->plan, ['pro', 'premium']);
    }

    public function checkout()
    {
        $user = auth()->user();

        // Save logo if any custom item
        $logoPath = null;
        $hasCustom = collect($this->items)->contains('design_type', 'custom');
        if ($hasCustom && $this->logoFile) {
            $logoPath = $this->logoFile->store('card-logos', 'public');
        }

        // Build items with profile names for admin display
        $profiles = $user->profiles->keyBy('id');
        $orderItems = [];
        foreach ($this->items as $item) {
            $profile = $profiles->get($item['profile_id']);
            $code = Card::generateUniqueCode();
            $orderItems[] = [
                'profile_id' => $item['profile_id'],
                'profile_name' => $profile ? ($profile->full_name ?? $profile->username) : 'Inconnu',
                'quantity' => $item['quantity'],
                'design_type' => $item['design_type'],
                'card_code' => $code,
            ];
        }

        // Create order
        $order = CardOrder::create([
            'user_id' => $user->id,
            'quantity' => $this->totalQuantity,
            'design_type' => $hasCustom ? 'custom' : 'standard',
            'logo_path' => $logoPath,
            'status' => 'pending',
            'shipping_address' => [
                'name' => $this->shippingName,
                'street' => $this->shippingStreet,
                'city' => $this->shippingCity,
                'province' => $this->shippingProvince,
                'postal_code' => $this->shippingPostalCode,
                'phone' => $this->shippingPhone,
                'country' => 'CA',
            ],
            'items' => $orderItems,
            'amount_cents' => $this->totalPrice,
        ]);

        // Create Stripe Checkout
        try {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'cad',
                        'product_data' => [
                            'name' => 'Cartes NFC Link-Card',
                            'description' => $this->totalQuantity . ' carte(s) NFC',
                        ],
                        'unit_amount' => $this->unitPrice,
                    ],
                    'quantity' => $this->totalQuantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('cards.order.success', ['order' => $order->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cards.order') . '?cancelled=1',
                'customer_email' => $user->email,
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                ],
            ]);

            $order->update(['stripe_session_id' => $session->id]);

            return $this->redirect($session->url, navigate: false);

        } catch (\Exception $e) {
            Log::error('Stripe checkout error', ['error' => $e->getMessage()]);
            $order->delete();
            session()->flash('error', 'Erreur de paiement. Veuillez réessayer.');
        }
    }

    public function render()
    {
        return view('livewire.cards.order', [
            'profiles' => auth()->user()->profiles,
        ])->layout('layouts.dashboard');
    }
}
