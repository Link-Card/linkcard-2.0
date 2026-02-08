<?php

namespace App\Livewire\Cards;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CardOrder;
use Illuminate\Support\Facades\Log;

class Order extends Component
{
    use WithFileUploads;

    // Form fields
    public int $quantity = 1;
    public string $designType = 'standard';
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

    protected $rules = [
        'quantity' => 'required|integer|min:1|max:10',
        'designType' => 'required|in:standard,custom',
        'logoFile' => 'nullable|image|max:15360',
        'shippingName' => 'required|string|max:255',
        'shippingStreet' => 'required|string|max:255',
        'shippingCity' => 'required|string|max:255',
        'shippingProvince' => 'required|string|max:2',
        'shippingPostalCode' => 'required|string|max:10',
        'shippingPhone' => 'required|string|max:20',
    ];

    protected $messages = [
        'shippingName.required' => 'Le nom est requis.',
        'shippingStreet.required' => 'L\'adresse est requise.',
        'shippingCity.required' => 'La ville est requise.',
        'shippingPostalCode.required' => 'Le code postal est requis.',
        'shippingPhone.required' => 'Le téléphone est requis.',
        'logoFile.image' => 'Le fichier doit être une image.',
        'logoFile.max' => 'Le logo ne doit pas dépasser 5 Mo.',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->shippingName = $user->name ?? '';
    }

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'quantity' => 'required|integer|min:1|max:10',
                'designType' => 'required|in:standard,custom',
            ]);

            if ($this->designType === 'custom') {
                $this->validate(['logoFile' => 'required|image|max:15360']);
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

    public function incrementQuantity()
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function getUnitPriceProperty(): int
    {
        return CardOrder::getPriceForUser(auth()->user());
    }

    public function getTotalPriceProperty(): int
    {
        return $this->unitPrice * $this->quantity;
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
        return auth()->user()->plan === 'premium';
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
        if ($this->designType === 'custom' && $this->logoFile) {
            $logoPath = $this->logoFile->store('card-logos', 'public');
        }

        // Create order in DB
        $order = CardOrder::create([
            'user_id' => $user->id,
            'quantity' => $this->quantity,
            'design_type' => $this->designType,
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
                            'name' => 'Carte NFC Link-Card' . ($this->designType === 'custom' ? ' (Custom)' : ''),
                            'description' => 'Carte de visite NFC - Quantité: ' . $this->quantity,
                        ],
                        'unit_amount' => $this->unitPrice,
                    ],
                    'quantity' => $this->quantity,
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
        $noProfiles = auth()->user()->profiles()->count() === 0;

        return view('livewire.cards.order', [
            'noProfiles' => $noProfiles,
        ])->layout('layouts.dashboard');
    }
}
