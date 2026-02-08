<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CardOrder;
use Illuminate\Support\Facades\Log;

class Order extends Component
{
    use WithFileUploads;

    // Multi-item cart
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
    public int $step = 1; // 1=design, 2=address, 3=summary

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

        $firstProfile = $user->profiles()->first();
        $this->items = [[
            'order_type' => 'new',
            'profile_id' => $firstProfile?->id ?? '',
            'design_type' => 'standard',
            'quantity' => 1,
            'replace_card_id' => '',
        ]];
    }

    public function addItem()
    {
        $firstProfile = auth()->user()->profiles()->first();
        $this->items[] = [
            'order_type' => 'new',
            'profile_id' => $firstProfile?->id ?? '',
            'design_type' => 'standard',
            'quantity' => 1,
            'replace_card_id' => '',
        ];
    }

    public function removeItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
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
            // Validate items
            foreach ($this->items as $index => $item) {
                if (($item['order_type'] ?? 'new') === 'replacement' && empty($item['replace_card_id'])) {
                    $this->addError("items.{$index}.replace_card_id", 'Sélectionnez une carte à remplacer.');
                    return;
                }
            }

            $hasCustom = collect($this->items)->contains('design_type', 'custom');
            if ($hasCustom && !$this->logoFile) {
                $this->validate(['logoFile' => 'required|image|max:15360']);
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
        return in_array(auth()->user()->plan, ['premium', 'pro']);
    }

    public function checkout()
    {
        if (session('impersonating_from')) {
            session()->flash('error', 'Les achats ne sont pas disponibles en mode assistance.');
            return;
        }

        $user = auth()->user();

        // Save logo if custom
        $logoPath = null;
        $hasCustom = collect($this->items)->contains('design_type', 'custom');
        if ($hasCustom && $this->logoFile) {
            $logoPath = $this->logoFile->store('card-logos', 'public');
        }

        // Determine overall design type
        $designType = $hasCustom ? 'custom' : 'standard';

        // Expand items: generate a card_code per card
        $expandedItems = [];
        foreach ($this->items as $item) {
            $qty = $item['quantity'] ?? 1;
            for ($i = 0; $i < $qty; $i++) {
                $expandedItems[] = [
                    'order_type' => $item['order_type'] ?? 'new',
                    'profile_id' => $item['profile_id'] ?? null,
                    'design_type' => $item['design_type'] ?? 'standard',
                    'replace_card_id' => $item['replace_card_id'] ?? null,
                    'card_code' => ($item['order_type'] ?? 'new') === 'replacement' && !empty($item['replace_card_id'])
                        ? \App\Models\Card::find($item['replace_card_id'])?->card_code ?? \App\Models\Card::generateUniqueCode()
                        : \App\Models\Card::generateUniqueCode(),
                ];
            }
        }

        // Create order in DB
        $order = CardOrder::create([
            'user_id' => $user->id,
            'quantity' => $this->totalQuantity,
            'design_type' => $designType,
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
            'amount_cents' => $this->totalPrice,
            'items' => $expandedItems,
        ]);

        // Create Stripe Checkout Session
        try {
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'cad',
                        'product_data' => [
                            'name' => 'Carte NFC Link-Card' . ($hasCustom ? ' (Custom)' : ''),
                            'description' => 'Carte de visite NFC - Quantité: ' . $this->totalQuantity,
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

            Log::info('Card order checkout created', [
                'order_id' => $order->id,
                'session_id' => $session->id,
                'amount' => $this->totalPrice,
            ]);

            return $this->redirect($session->url, navigate: false);

        } catch (\Exception $e) {
            Log::error('Stripe checkout error', ['error' => $e->getMessage()]);
            $order->delete();
            session()->flash('error', 'Erreur de paiement. Veuillez réessayer.');
        }
    }

    public function render()
    {
        $user = auth()->user();
        $noProfiles = $user->profiles()->count() === 0;
        $profiles = $user->profiles;
        $existingCards = $user->cards()->with('profile')->get();

        return view('livewire.cards.order', [
            'noProfiles' => $noProfiles,
            'profiles' => $profiles,
            'existingCards' => $existingCards,
        ])->layout('layouts.dashboard');
    }
}
