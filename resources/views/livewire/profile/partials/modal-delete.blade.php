@if($showDeleteModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 p-4"
         style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
         wire:click.self="cancelDelete">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center" style="box-shadow: 0 20px 48px rgba(0,0,0,0.2);">
            
            <!-- Icône -->
            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background: #FEF2F2;">
                <svg class="w-8 h-8" fill="#EF4444" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
            </div>
            
            <!-- Titre -->
            <h3 class="text-lg font-semibold mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                Supprimer cette bande ?
            </h3>
            
            <!-- Description -->
            <p class="text-sm mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                « <strong>{{ $deletingBandName }}</strong> » sera supprimé définitivement.
            </p>
            
            <!-- Boutons -->
            <div class="flex space-x-3">
                <button wire:click="cancelDelete" 
                        class="flex-1 py-2.5 rounded-lg font-medium text-sm transition-all duration-200"
                        style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;"
                        onmouseover="this.style.background='#E5E7EB'"
                        onmouseout="this.style.background='#F3F4F6'">
                    Annuler
                </button>
                <button wire:click="deleteBand" 
                        class="flex-1 py-2.5 rounded-lg font-medium text-sm text-white transition-all duration-200"
                        style="font-family: 'Manrope', sans-serif; background: #EF4444;"
                        onmouseover="this.style.background='#DC2626'"
                        onmouseout="this.style.background='#EF4444'">
                    Supprimer
                </button>
            </div>
        </div>
    </div>
@endif
