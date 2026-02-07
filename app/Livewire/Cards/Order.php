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

    public array $items = [];
    public $logoFile = null;
    public bool $noProfiles = false;

    // Shipping
    public string $shippingName = '';
    public string $shippingStreet = '';
    public string $shippingCity = '';
    public string $shippingProvince = 'QC';
    public string $shippingPostalCode = '';
    public string $shippingPhone = '';

    public int $step = 1;

    protected $messages = [
        'shippingName.required' => 'Le nom est requis.',
        'shippingStreet.required' => 'L\'adresse est requise.',
        'shippingCity.required' => 'La ville est requise.',
        'shippingPostalCode.required' => 'Le code postal est requis.',
        'shippingPhone.required' => 'Le téléphone est requis.',
        'logoFile.mimes' => 'Le logo doit être au format PNG (fond transparent recommandé).',
        'logoFile.max' => 'Le logo ne doit pas dépasser 15 Mo.',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->shippingName = $user->name ?? '';

        // Cleanup old pending orders
        CardOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subHour())
            ->delete();

        $profiles = $user->profiles;
        if ($profiles->count() === 0) {
            $this->noProfiles = true;
            return;
        }

        $this->items = [[
            'profile_id' => $profiles->first()->id,
            'quantity' => 1,
            'design_type' => 'standard',
            'order_type' => 'new',
            'replace_card_id' => null,
        ]];
    }

    public function addItem()
    {
        $profiles = auth()->user()->profiles;
        if ($profiles->count() === 0) return;

        $this->items[] = [
            'profile_id' => $profiles->first()->id,
            'quantity' => 1,
            'design_type' => 'standard',
            'order_type' => 'new',
            'replace_card_id' => null,
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
            // Replacements are always qty 1
            if (($this->items[$index]['order_type'] ?? 'new') === 'replacement') return;
            $this->items[$index]['quantity']++;
        }
    }

    public function decrementItem($index)
    {
        if (isset($this->items[$index]) && $this->items[$index]['quantity'] > 1) {
            $this->items[$index]['quantity']--;
        }
    }

    public function updatedItems($value, $key)
    {
        // When switching to replacement, force qty to 1
        if (str_contains($key, 'order_type') && $value === 'replacement') {
            $index = (int) explode('.', $key)[0];
            $this->items[$index]['quantity'] = 1;
        }
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            if (empty($this->items)) {
                session()->flash('error', 'Ajoutez au moins une carte.');
                return;
            }
            // Validate replacements have card selected
            foreach ($this->items as $item) {
                if (($item['order_type'] ?? 'new') === 'replacement' && empty($item['replace_card_id'])) {
                    session()->flash('error', 'Sélectionnez la carte à remplacer.');
                    return;
                }
            }
            $hasCustom = collect($this->items)->contains('design_type', 'custom');
            if ($hasCustom && !$this->logoFile) {
                $this->addError('logoFile', 'Le logo est requis pour le design personnalisé.');
                return;
            }
            if ($hasCustom && $this->logoFile) {
                $this->validate(['logoFile' => 'mimes:png|max:15360']);
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
        if ($this->step > 1) $this->step--;
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

        $logoPath = null;
        $hasCustom = collect($this->items)->contains('design_type', 'custom');
        if ($hasCustom && $this->logoFile) {
            $logoPath = $this->logoFile->store('card-logos', 'public');
        }

        $profiles = $user->profiles->keyBy('id');
        $existingCards = $user->cards->keyBy('id');
        $orderItems = [];

        foreach ($this->items as $item) {
            $profile = $profiles->get($item['profile_id']);
            $isReplacement = ($item['order_type'] ?? 'new') === 'replacement';

            if ($isReplacement && !empty($item['replace_card_id'])) {
                $existingCard = $existingCards->get($item['replace_card_id']);
                $code = $existingCard ? $existingCard->card_code : Card::generateUniqueCode();
            } else {
                $code = Card::generateUniqueCode();
            }

            $orderItems[] = [
                'profile_id' => $item['profile_id'],
                'profile_name' => $profile ? ($profile->full_name ?? $profile->username) : 'Inconnu',
                'profile_url' => $profile ? url('/' . $profile->username) : '',
                'quantity' => $item['quantity'],
                'design_type' => $item['design_type'],
                'card_code' => $code,
                'order_type' => $item['order_type'] ?? 'new',
                'is_replacement' => $isReplacement,
            ];
        }

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
        $user = auth()->user();
        return view('livewire.cards.order', [
            'profiles' => $user->profiles,
            'existingCards' => $user->cards()->with('profile')->get(),
        ])->layout('layouts.dashboard');
    }
}
