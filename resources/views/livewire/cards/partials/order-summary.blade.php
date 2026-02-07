<div>
    <h2 class="text-lg font-semibold mb-4" style="color: #2C2A27;">Résumé de la commande</h2>

    <!-- Items detail -->
    <div class="space-y-3 mb-4">
        @foreach($items as $index => $item)
            @php
                $profile = $profiles->firstWhere('id', $item['profile_id']);
            @endphp
            <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid #E5E7EB;">
                <div>
                    <p class="text-sm font-medium" style="color: #2C2A27;">{{ $profile ? ($profile->full_name ?? $profile->username) : 'Profil' }}</p>
                    <p class="text-xs" style="color: #4B5563;">{{ $item['quantity'] }} carte(s) · {{ $item['design_type'] === 'custom' ? 'Personnalisé' : 'Standard' }}</p>
                </div>
                <p class="text-sm font-medium" style="color: #2C2A27;">{{ number_format(($this->unitPrice * $item['quantity']) / 100, 2) }}$</p>
            </div>
        @endforeach
    </div>

    <!-- Total -->
    <div class="flex justify-between items-center py-3 mb-4" style="border-top: 2px solid #E5E7EB;">
        <p class="text-base font-semibold" style="color: #2C2A27;">Total ({{ $this->totalQuantity }} cartes · CAD)</p>
        <p class="text-xl font-bold" style="color: #42B574;">{{ $this->displayTotalPrice }}$</p>
    </div>

    <!-- Shipping address -->
    <div class="p-3 rounded-lg mb-4" style="background-color: #F7F8F4;">
        <p class="text-xs font-medium mb-1" style="color: #4B5563;">Livraison</p>
        <p class="text-sm" style="color: #2C2A27;">{{ $shippingName }}</p>
        <p class="text-xs" style="color: #4B5563;">{{ $shippingStreet }}, {{ $shippingCity }}, {{ $shippingProvince }} {{ $shippingPostalCode }}</p>
        <p class="text-xs" style="color: #4B5563;">{{ $shippingPhone }}</p>
    </div>

    <!-- Note -->
    <div class="p-3 rounded-lg mb-6" style="background-color: #F3F4F6;">
        <p class="text-xs" style="color: #4B5563;">
            Les taxes applicables seront calculées au paiement. Livraison gratuite au Canada. Délai: 5-10 jours ouvrables.
        </p>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between">
        <button wire:click="previousStep" class="px-6 py-3 rounded-lg font-medium text-sm transition-colors" style="color: #4B5563; border: 1px solid #D1D5DB;">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour
        </button>
        <button wire:click="checkout" wire:loading.attr="disabled" class="px-8 py-3 rounded-lg text-white font-medium transition-colors disabled:opacity-50" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
            <span wire:loading.remove wire:target="checkout">Payer {{ $this->displayTotalPrice }}$</span>
            <span wire:loading wire:target="checkout">Redirection vers Stripe...</span>
        </button>
    </div>
</div>
