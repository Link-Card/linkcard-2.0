<div>
    {{-- Report button (small, discrete) --}}
    <button wire:click="openModal" class="flex items-center space-x-1 text-xs transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3AF'">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
        </svg>
        <span>Signaler</span>
    </button>

    {{-- Report Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);" wire:click.self="closeModal">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 p-6" style="animation: reportPopIn 0.2s ease-out;">
                @if($submitted)
                    {{-- Success state --}}
                    <div class="text-center py-4">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
                            <svg class="w-7 h-7" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2" style="color: #2C2A27;">Signalement envoyé</h3>
                        <p class="text-sm mb-6" style="color: #4B5563;">Merci. Notre équipe examinera ce profil dans les meilleurs délais.</p>
                        <button wire:click="closeModal" class="px-6 py-2.5 rounded-lg text-white text-sm font-medium" style="background-color: #42B574;">
                            Fermer
                        </button>
                    </div>
                @else
                    {{-- Report form --}}
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #FEF2F2;">
                            <svg class="w-5 h-5" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold" style="color: #2C2A27;">Signaler ce profil</h3>
                            <p class="text-xs" style="color: #9CA3AF;">Aidez-nous à garder Link-Card sûr</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Reason --}}
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="color: #4B5563;">Raison *</label>
                            <select wire:model="reason" class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB; color: #2C2A27;">
                                <option value="">Sélectionner une raison...</option>
                                <option value="explicit_content">Contenu explicite / sexuel</option>
                                <option value="illegal_content">Contenu illégal</option>
                                <option value="dangerous_links">Liens dangereux / malveillants</option>
                                <option value="harassment">Harcèlement / menaces</option>
                                <option value="hate_speech">Discours haineux</option>
                                <option value="spam">Spam / arnaque</option>
                                <option value="impersonation">Usurpation d'identité</option>
                                <option value="other">Autre</option>
                            </select>
                            @error('reason') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        {{-- Details --}}
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="color: #4B5563;">Détails (optionnel)</label>
                            <textarea wire:model="details" rows="3" class="w-full text-sm rounded-xl border px-3 py-2.5" style="border-color: #D1D5DB; color: #2C2A27;" placeholder="Décrivez le problème..."></textarea>
                        </div>

                        {{-- Actions --}}
                        <div class="flex space-x-3 pt-2">
                            <button wire:click="closeModal" class="flex-1 px-4 py-2.5 text-sm rounded-xl font-medium" style="color: #4B5563; border: 1.5px solid #D1D5DB;">
                                Annuler
                            </button>
                            <button wire:click="submit" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 text-sm rounded-xl text-white font-medium disabled:opacity-60" style="background-color: #EF4444;">
                                <span wire:loading.remove wire:target="submit">Envoyer le signalement</span>
                                <span wire:loading wire:target="submit">Envoi...</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <style>
        @keyframes reportPopIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>
</div>
