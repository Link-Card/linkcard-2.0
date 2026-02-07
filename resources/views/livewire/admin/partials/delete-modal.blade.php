{{-- Delete confirmation modal --}}
@if($deletingOrderId)
    <div class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5);" wire:click.self="cancelDelete">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #FEF2F2;">
                <svg class="w-7 h-7" style="color: #EF4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-center mb-2" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Supprimer la commande #{{ $deletingOrderId }}</h3>
            <p class="text-sm text-center mb-5" style="color: #4B5563;">Cette action est irréversible. Le montant sera retiré des revenus et les cartes associées supprimées.</p>

            <div class="mb-3">
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Raison de la suppression *</label>
                <select wire:model.live="deleteReason" class="w-full text-sm rounded-xl border px-3 py-2.5 focus:outline-none" style="border-color: #D1D5DB;">
                    <option value="">-- Sélectionner une raison --</option>
                    <option value="refund">Remboursement client</option>
                    <option value="fraud">Fraude / paiement contesté</option>
                    <option value="user_deleted">Utilisateur supprimé</option>
                    <option value="duplicate">Commande en double</option>
                    <option value="test">Commande de test</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium mb-1" style="color: #2C2A27;">Justification / Notes</label>
                <textarea wire:model="deleteNote" rows="3" placeholder="Ajoutez des détails pour le rapport..."
                          class="w-full text-sm rounded-xl border px-3 py-2.5 focus:outline-none resize-none" style="border-color: #D1D5DB;"></textarea>
            </div>

            <div class="flex space-x-3">
                <button wire:click="cancelDelete" class="flex-1 px-4 py-3 text-sm rounded-xl font-medium transition-colors" style="border: 2px solid #D1D5DB; color: #4B5563;">
                    Annuler
                </button>
                @if($deleteReason)
                    <button wire:click="deleteOrder" class="flex-1 px-4 py-3 text-sm rounded-xl font-medium text-white transition-colors" style="background-color: #EF4444;">
                        Supprimer définitivement
                    </button>
                @else
                    <button disabled class="flex-1 px-4 py-3 text-sm rounded-xl font-medium text-white opacity-40 cursor-not-allowed" style="background-color: #EF4444;">
                        Supprimer définitivement
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif
