<div x-data="{ open: false }" x-cloak
     class="bg-white rounded-xl overflow-hidden"
     style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <button @click="open = !open"
            class="w-full flex items-center justify-between px-5 py-4 transition-colors"
            style="font-family: 'Manrope', sans-serif;"
            :style="open ? 'background: #FAFAFA' : ''">
        <div class="flex items-center space-x-3">
            <span class="text-lg">👤</span>
            <span class="font-medium text-sm" style="color: #2C2A27;">Informations du profil</span>
        </div>
        <svg class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9CA3AF;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition style="border-top: 1px solid #E5E7EB;">
        <div class="px-5 py-5 space-y-4">

            <!-- Photo -->
            <div>
                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Photo de profil</label>
                <div class="flex items-center space-x-4">
                    @if($profile->photo_path)
                        <img src="{{ Storage::url($profile->photo_path) }}" class="w-16 h-16 rounded-full object-cover" style="border: 2px solid #E5E7EB;">
                    @else
                        <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: #F3F4F6; border: 2px solid #E5E7EB;">
                            <span class="text-2xl">👤</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" wire:model="photo" accept="image/*" class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                        <div wire:loading wire:target="photo" class="flex items-center space-x-1 mt-1">
                            <svg class="animate-spin h-3 w-3" style="color: #42B574;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <span class="text-xs" style="color: #9CA3AF;">Upload...</span>
                        </div>
                        @error('photo') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Nom -->
            <div>
                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nom complet *</label>
                <input type="text" wire:model.live.debounce.500ms="full_name" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                @error('full_name') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
            </div>

            <!-- Titre / Poste -->
            <div>
                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Titre / Poste</label>
                <input type="text" wire:model.live.debounce.500ms="job_title" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
            </div>

            <!-- Entreprise + Localisation (côte à côte) -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Entreprise</label>
                    <input type="text" wire:model.live.debounce.500ms="company" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                </div>
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Localisation</label>
                    <input type="text" wire:model.live.debounce.500ms="location" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                </div>
            </div>

            <!-- Email + Téléphone (côte à côte) -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Email</label>
                    <input type="email" wire:model.live.debounce.500ms="email" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    @error('email') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Téléphone</label>
                    <input type="tel" wire:model.live.debounce.500ms="phone" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                </div>
            </div>

            <!-- Couleurs (côte à côte) -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Couleur 1 (haut)</label>
                    <input type="color" wire:model.live.debounce.500ms="primary_color" class="h-11 w-full rounded-lg cursor-pointer" style="border: 1.5px solid #D1D5DB;">
                </div>
                <div>
                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Couleur 2 (bas)</label>
                    <input type="color" wire:model.live.debounce.500ms="secondary_color" class="h-11 w-full rounded-lg cursor-pointer" style="border: 1.5px solid #D1D5DB;">
                </div>
            </div>

            <button @click="open = false" class="w-full py-2.5 rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;" onmouseover="this.style.background='#42B574'; this.style.color='#FFFFFF'" onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                ✓ Valider
            </button>
        </div>
    </div>
</div>
