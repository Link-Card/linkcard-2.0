<div>
    @section('title', 'Créer un profil')

    <div class="max-w-xl mx-auto py-12 px-4">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-green-50 mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-gray-900">Nouveau profil</h1>
            <p class="text-gray-500 mt-2">Entrez les informations de base. Vous pourrez tout personnaliser ensuite.</p>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">

            <div class="space-y-5">
                <!-- Nom complet -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Nom complet *</label>
                    <input type="text" wire:model="full_name" placeholder="Ex: Jean Dupont"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                    @error('full_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Titre du poste -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Titre du poste</label>
                    <input type="text" wire:model="job_title" placeholder="Ex: Directeur marketing"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>

                <!-- Entreprise -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Entreprise</label>
                    <input type="text" wire:model="company" placeholder="Ex: Acme Inc."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                </div>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('profile.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                    ← Retour
                </a>
                <button wire:click="submit" wire:loading.attr="disabled"
                    class="px-8 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition shadow-sm">
                    <span wire:loading.remove>Créer et personnaliser →</span>
                    <span wire:loading>Création...</span>
                </button>
            </div>
        </div>

        <!-- Info -->
        <p class="text-center text-xs text-gray-400 mt-6">
            Photo, couleurs, réseaux sociaux et plus — tout se configure à l'étape suivante.
        </p>

    </div>
</div>
