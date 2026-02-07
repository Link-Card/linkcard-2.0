<div>
    <h2 class="text-lg font-semibold mb-4" style="color: #2C2A27;">Choisissez votre design</h2>

    <!-- Design type -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <!-- Standard -->
        <label class="cursor-pointer">
            <input type="radio" wire:model.live="designType" value="standard" class="sr-only">
            <div class="border-2 rounded-xl p-4 text-center transition-all {{ $designType === 'standard' ? 'shadow-md' : 'hover:border-gray-300' }}"
                 style="border-color: {{ $designType === 'standard' ? '#42B574' : '#E5E7EB' }};">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                    <svg class="w-6 h-6" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <p class="font-semibold text-sm" style="color: #2C2A27;">Standard</p>
                <p class="text-xs mt-1" style="color: #4B5563;">Design Link-Card classique</p>
            </div>
        </label>

        <!-- Custom -->
        <label class="cursor-pointer">
            <input type="radio" wire:model.live="designType" value="custom" class="sr-only">
            <div class="border-2 rounded-xl p-4 text-center transition-all {{ $designType === 'custom' ? 'shadow-md' : 'hover:border-gray-300' }}"
                 style="border-color: {{ $designType === 'custom' ? '#42B574' : '#E5E7EB' }};">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                    <svg class="w-6 h-6" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="font-semibold text-sm" style="color: #2C2A27;">Personnalisé</p>
                <p class="text-xs mt-1" style="color: #4B5563;">Votre logo sur la carte</p>
            </div>
        </label>
    </div>

    <!-- Logo upload (if custom) -->
    @if($designType === 'custom')
        <div class="mb-6 p-4 rounded-lg" style="background-color: #F7F8F4;">
            <label class="block text-sm font-medium mb-2" style="color: #2C2A27;">Téléchargez votre logo</label>
            <input type="file" wire:model="logoFile" accept="image/*" class="w-full text-sm" style="color: #4B5563;">
            @error('logoFile')
                <p class="text-sm mt-1" style="color: #EF4444;">{{ $message }}</p>
            @enderror
            @if($logoFile)
                <div class="mt-3">
                    <img src="{{ $logoFile->temporaryUrl() }}" class="h-16 rounded-lg">
                </div>
            @endif
            <p class="text-xs mt-2" style="color: #9CA3AF;">Format: PNG, JPG. Max 5 Mo. Fond transparent recommandé.</p>
        </div>
    @endif

    <!-- Quantity -->
    <div class="mb-6">
        <label class="block text-sm font-medium mb-2" style="color: #2C2A27;">Quantité</label>
        <div class="flex items-center space-x-3">
            <button wire:click="decrementQuantity"
                    type="button"
                    class="w-10 h-10 rounded-lg border flex items-center justify-center transition-colors"
                    style="border-color: #D1D5DB; color: #4B5563;"
                    {{ $quantity <= 1 ? 'disabled' : '' }}>
                −
            </button>
            <input type="number" wire:model.live="quantity" min="1" max="10"
                   class="w-16 text-center rounded-lg border px-2 py-2 text-sm"
                   style="border-color: #D1D5DB; color: #2C2A27;">
            <button wire:click="incrementQuantity"
                    type="button"
                    class="w-10 h-10 rounded-lg border flex items-center justify-center transition-colors"
                    style="border-color: #D1D5DB; color: #4B5563;"
                    {{ $quantity >= 10 ? 'disabled' : '' }}>
                +
            </button>
        </div>
        @error('quantity')
            <p class="text-sm mt-1" style="color: #EF4444;">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price display -->
    <div class="p-4 rounded-lg mb-6" style="background-color: #F0F9F4;">
        <div class="flex justify-between items-center">
            <span class="text-sm" style="color: #4B5563;">Prix unitaire</span>
            <div>
                @if($this->hasDiscount)
                    <span class="text-xs line-through mr-2" style="color: #9CA3AF;">49.99$</span>
                @endif
                <span class="font-semibold" style="color: #2C2A27;">{{ $this->displayUnitPrice }}$</span>
            </div>
        </div>
        @if(auth()->user()->plan === 'premium')
            <p class="text-xs mt-1" style="color: #42B574;">Réduction PREMIUM de 25% appliquée!</p>
        @elseif(auth()->user()->plan === 'pro')
            <p class="text-xs mt-1" style="color: #42B574;">Réduction PRO de 10% appliquée!</p>
            <p class="text-xs mt-1" style="color: #4A7FBF;">💎 Passez à PREMIUM pour seulement 37.49$ / carte (-25%)</p>
        @else
            <p class="text-xs mt-1" style="color: #4A7FBF;">💎 Abonnez-vous PRO pour 44.99$ ou PREMIUM pour 37.49$ / carte</p>
        @endif
        @if($quantity > 1)
            <div class="flex justify-between items-center mt-2 pt-2" style="border-top: 1px solid #D1D5DB;">
                <span class="text-sm font-medium" style="color: #2C2A27;">Total ({{ $quantity }} cartes)</span>
                <span class="text-lg font-semibold" style="color: #42B574;">{{ $this->displayTotalPrice }}$</span>
            </div>
        @endif
    </div>

    <!-- Next button -->
    <div class="flex justify-end">
        <button wire:click="nextStep" class="px-6 py-3 rounded-lg text-white font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
            Continuer
            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>
