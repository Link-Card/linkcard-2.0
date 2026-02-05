@props(['show' => false, 'name' => '', 'type' => '', 'action' => 'delete'])

@if($show)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6" style="box-shadow: 0 20px 48px rgba(0,0,0,0.2);">
        
        @if($action === 'reset')
            <!-- Réinitialiser -->
            <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4" style="background: #FEF3C7;">
                <svg class="w-7 h-7" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-center mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Réinitialiser {{ $type }} ?</h3>
            <p class="text-sm text-center mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                Le contenu de <strong>{{ $name }}</strong> sera effacé mais l'URL restera actif.
            </p>
        @else
            <!-- Supprimer -->
            <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4" style="background: #FEF2F2;">
                <svg class="w-7 h-7" fill="#EF4444" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-center mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Supprimer {{ $type }} ?</h3>
            <p class="text-sm text-center mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                <strong>{{ $name }}</strong> sera définitivement supprimé.
            </p>
        @endif

        <div class="flex space-x-3">
            <button wire:click="cancelDelete" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                Annuler
            </button>
            @if($action === 'reset')
                <button wire:click="resetConfirmed" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium text-white transition-colors" style="font-family: 'Manrope', sans-serif; background: #F59E0B;" onmouseover="this.style.background='#D97706'" onmouseout="this.style.background='#F59E0B'">
                    Réinitialiser
                </button>
            @else
                <button wire:click="deleteConfirmed" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium text-white transition-colors" style="font-family: 'Manrope', sans-serif; background: #EF4444;" onmouseover="this.style.background='#DC2626'" onmouseout="this.style.background='#EF4444'">
                    Supprimer
                </button>
            @endif
        </div>
    </div>
</div>
@endif
