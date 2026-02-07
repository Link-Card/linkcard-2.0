<div>
    <h2 class="text-lg font-semibold mb-4" style="color: #2C2A27;">Résumé de la commande</h2>

    <!-- Order details -->
    <div class="space-y-4 mb-6">
        <!-- Design -->
        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid #E5E7EB;">
            <div>
                <p class="text-sm font-medium" style="color: #2C2A27;">Design</p>
                <p class="text-xs" style="color: #4B5563;">{{ $designType === 'custom' ? 'Personnalisé (avec logo)' : 'Standard Link-Card' }}</p>
            </div>
            @if($designType === 'custom' && $logoFile)
                <img src="{{ $logoFile->temporaryUrl() }}" class="h-10 rounded">
            @else
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                    <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            @endif
        </div>

        <!-- Quantity + Price -->
        <div class="flex justify-between items-center py-3" style="border-bottom: 1px solid #E5E7EB;">
            <div>
                <p class="text-sm font-medium" style="color: #2C2A27;">{{ $quantity }} carte(s) NFC</p>
                <p class="text-xs" style="color: #4B5563;">{{ $this->displayUnitPrice }}$ / carte
                    @if($this->hasDiscount)
                        <span style="color: #42B574;">(PREMIUM -25%)</span>
                    @endif
                </p>
            </div>
            <p class="font-semibold" style="color: #2C2A27;">{{ $this->displayTotalPrice }}$</p>
        </div>

        <!-- Shipping address -->
        <div class="py-3" style="border-bottom: 1px solid #E5E7EB;">
            <p class="text-sm font-medium mb-1" style="color: #2C2A27;">Livraison</p>
            <div class="text-xs" style="color: #4B5563;">
                <p>{{ $shippingName }}</p>
                <p>{{ $shippingStreet }}</p>
                <p>{{ $shippingCity }}, {{ $shippingProvince }} {{ $shippingPostalCode }}</p>
                <p>{{ $shippingPhone }}</p>
            </div>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center pt-2">
            <p class="text-base font-semibold" style="color: #2C2A27;">Total (CAD)</p>
            <p class="text-xl font-bold" style="color: #42B574;">{{ $this->displayTotalPrice }}$</p>
        </div>
    </div>

    <!-- Taxes note -->
    <div class="p-3 rounded-lg mb-6" style="background-color: #F3F4F6;">
        <p class="text-xs" style="color: #4B5563;">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Les taxes applicables seront calculées au paiement. Livraison gratuite au Canada.
        </p>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between">
        <button wire:click="previousStep" class="px-6 py-3 rounded-lg font-medium text-sm transition-colors" style="color: #4B5563; border: 1px solid #D1D5DB;" onmouseover="this.style.backgroundColor='#F3F4F6'" onmouseout="this.style.backgroundColor='transparent'">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour
        </button>
        <button wire:click="checkout"
                wire:loading.attr="disabled"
                class="px-8 py-3 rounded-lg text-white font-medium transition-colors disabled:opacity-50"
                style="background-color: #42B574;"
                onmouseover="this.style.backgroundColor='#3DA367'"
                onmouseout="this.style.backgroundColor='#42B574'">
            <span wire:loading.remove wire:target="checkout">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Payer {{ $this->displayTotalPrice }}$
            </span>
            <span wire:loading wire:target="checkout">
                Redirection vers Stripe...
            </span>
        </button>
    </div>
</div>
