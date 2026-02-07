<div>
    <h2 class="text-lg font-semibold mb-4" style="color: #2C2A27;">Vos cartes NFC</h2>

    <!-- Cart items -->
    <div class="space-y-3 mb-6">
        @foreach($items as $index => $item)
            <div class="border rounded-xl p-4" style="border-color: #E5E7EB;">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium" style="color: #2C2A27;">Carte {{ $index + 1 }}</span>
                    @if(count($items) > 1)
                        <button wire:click="removeItem({{ $index }})" class="text-xs px-2 py-1 rounded" style="color: #EF4444;" title="Retirer">✕</button>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- Profile selector -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Profil lié</label>
                        <select wire:model.live="items.{{ $index }}.profile_id" class="w-full text-sm rounded-lg border px-3 py-2" style="border-color: #D1D5DB; color: #2C2A27;">
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->full_name ?? $profile->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Design type -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Design</label>
                        <select wire:model.live="items.{{ $index }}.design_type" class="w-full text-sm rounded-lg border px-3 py-2" style="border-color: #D1D5DB; color: #2C2A27;">
                            <option value="standard">Standard</option>
                            <option value="custom">Personnalisé (logo)</option>
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #4B5563;">Quantité</label>
                        <div class="flex items-center space-x-2">
                            <button wire:click="decrementItem({{ $index }})" type="button"
                                    class="w-8 h-8 rounded-lg border flex items-center justify-center text-sm"
                                    style="border-color: #D1D5DB; color: #4B5563;">−</button>
                            <span class="w-8 text-center text-sm font-medium" style="color: #2C2A27;">{{ $item['quantity'] }}</span>
                            <button wire:click="incrementItem({{ $index }})" type="button"
                                    class="w-8 h-8 rounded-lg border flex items-center justify-center text-sm"
                                    style="border-color: #D1D5DB; color: #4B5563;">+</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add item button -->
    @if($profiles->count() > 0)
        <button wire:click="addItem" class="w-full py-3 rounded-xl border-2 border-dashed text-sm font-medium transition-colors" style="border-color: #D1D5DB; color: #4B5563;" onmouseover="this.style.borderColor='#42B574'; this.style.color='#42B574'" onmouseout="this.style.borderColor='#D1D5DB'; this.style.color='#4B5563'">
            + Ajouter un autre profil
        </button>
    @endif

    <!-- Logo upload if any custom -->
    @if(collect($items)->contains('design_type', 'custom'))
        <div class="mt-4 p-4 rounded-lg" style="background-color: #F7F8F4;">
            <label class="block text-sm font-medium mb-2" style="color: #2C2A27;">Logo pour les cartes personnalisées</label>
            <input type="file" wire:model="logoFile" accept="image/*" class="w-full text-sm" style="color: #4B5563;">
            @error('logoFile')
                <p class="text-sm mt-1" style="color: #EF4444;">{{ $message }}</p>
            @enderror
            @if($logoFile)
                <div class="mt-3">
                    <img src="{{ $logoFile->temporaryUrl() }}" class="h-16 rounded-lg">
                </div>
            @endif
            <p class="text-xs mt-2" style="color: #9CA3AF;">PNG, JPG. Max 15 Mo. Fond transparent recommandé.</p>
        </div>
    @endif

    <!-- Price display -->
    <div class="p-4 rounded-lg mt-4 mb-6" style="background-color: #F0F9F4;">
        <div class="flex justify-between items-center">
            <span class="text-sm" style="color: #4B5563;">{{ $this->totalQuantity }} carte(s) × {{ $this->displayUnitPrice }}$</span>
            <div>
                @if($this->hasDiscount)
                    <span class="text-xs line-through mr-2" style="color: #9CA3AF;">{{ number_format(49.99 * $this->totalQuantity, 2) }}$</span>
                @endif
                <span class="text-lg font-semibold" style="color: #42B574;">{{ $this->displayTotalPrice }}$</span>
            </div>
        </div>
        @if(auth()->user()->plan === 'premium')
            <p class="text-xs mt-1" style="color: #42B574;">Réduction PREMIUM de 25% appliquée!</p>
        @elseif(auth()->user()->plan === 'pro')
            <p class="text-xs mt-1" style="color: #42B574;">Réduction PRO de 10% appliquée!</p>
            <p class="text-xs mt-1" style="color: #4A7FBF;">💎 Passez à PREMIUM pour 37.49$ / carte (-25%)</p>
        @else
            <p class="text-xs mt-1" style="color: #4A7FBF;">💎 Abonnez-vous PRO (44.99$) ou PREMIUM (37.49$) / carte</p>
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
