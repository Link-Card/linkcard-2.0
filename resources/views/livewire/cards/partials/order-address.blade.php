<div>
    <h2 class="text-lg font-semibold mb-4" style="color: #2C2A27;">Adresse de livraison</h2>

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Nom complet</label>
            <input type="text" wire:model="shippingName" placeholder="Jean Dupont"
                   class="w-full rounded-lg border px-4 py-3 text-sm transition-colors focus:outline-none"
                   style="border-color: #D1D5DB; color: #2C2A27;"
                   onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
            @error('shippingName')
                <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Street -->
        <div>
            <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Adresse</label>
            <input type="text" wire:model="shippingStreet" placeholder="123 rue Exemple, app. 4"
                   class="w-full rounded-lg border px-4 py-3 text-sm transition-colors focus:outline-none"
                   style="border-color: #D1D5DB; color: #2C2A27;"
                   onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
            @error('shippingStreet')
                <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
            @enderror
        </div>

        <!-- City + Province -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Ville</label>
                <input type="text" wire:model="shippingCity" placeholder="Montréal"
                       class="w-full rounded-lg border px-4 py-3 text-sm transition-colors focus:outline-none"
                       style="border-color: #D1D5DB; color: #2C2A27;"
                       onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                @error('shippingCity')
                    <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Province</label>
                <select wire:model="shippingProvince"
                        class="w-full rounded-lg border px-4 py-3 text-sm"
                        style="border-color: #D1D5DB; color: #2C2A27;">
                    <option value="AB">Alberta</option>
                    <option value="BC">Colombie-Britannique</option>
                    <option value="MB">Manitoba</option>
                    <option value="NB">Nouveau-Brunswick</option>
                    <option value="NL">Terre-Neuve-et-Labrador</option>
                    <option value="NS">Nouvelle-Écosse</option>
                    <option value="NT">Territoires du Nord-Ouest</option>
                    <option value="NU">Nunavut</option>
                    <option value="ON">Ontario</option>
                    <option value="PE">Île-du-Prince-Édouard</option>
                    <option value="QC">Québec</option>
                    <option value="SK">Saskatchewan</option>
                    <option value="YT">Yukon</option>
                </select>
            </div>
        </div>

        <!-- Postal code + Phone -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Code postal</label>
                <input type="text" wire:model="shippingPostalCode" placeholder="G0X 2Z0"
                       class="w-full rounded-lg border px-4 py-3 text-sm transition-colors focus:outline-none"
                       style="border-color: #D1D5DB; color: #2C2A27;"
                       onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                @error('shippingPostalCode')
                    <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Téléphone</label>
                <input type="tel" wire:model="shippingPhone" placeholder="819-555-1234"
                       class="w-full rounded-lg border px-4 py-3 text-sm transition-colors focus:outline-none"
                       style="border-color: #D1D5DB; color: #2C2A27;"
                       onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                @error('shippingPhone')
                    <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <p class="text-xs mt-4" style="color: #9CA3AF;">
        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Livraison au Canada seulement. Délai estimé: 5-10 jours ouvrables.
    </p>

    <!-- Navigation -->
    <div class="flex justify-between mt-6">
        <button wire:click="previousStep" class="px-6 py-3 rounded-lg font-medium text-sm transition-colors" style="color: #4B5563; border: 1px solid #D1D5DB;" onmouseover="this.style.backgroundColor='#F3F4F6'" onmouseout="this.style.backgroundColor='transparent'">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour
        </button>
        <button wire:click="nextStep" class="px-6 py-3 rounded-lg text-white font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
            Continuer
            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>
