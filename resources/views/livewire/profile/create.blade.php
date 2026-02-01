<div>
    @section('title', 'Créer un profil')

    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Stepper -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <!-- Étape 1 -->
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full
                        {{ $currentStep >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium {{ $currentStep >= 1 ? 'text-indigo-600' : 'text-gray-500' }}">
                        Informations
                    </span>
                </div>

                <!-- Ligne progression -->
                <div class="flex-1 h-1 mx-4 {{ $currentStep >= 2 ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>

                <!-- Étape 2 -->
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full
                        {{ $currentStep >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium {{ $currentStep >= 2 ? 'text-indigo-600' : 'text-gray-500' }}">
                        Design
                    </span>
                </div>

                <!-- Ligne progression -->
                <div class="flex-1 h-1 mx-4 {{ $currentStep >= 3 ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>

                <!-- Étape 3 -->
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full
                        {{ $currentStep >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium {{ $currentStep >= 3 ? 'text-indigo-600' : 'text-gray-500' }}">
                        Photo
                    </span>
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow p-6">
            @if($currentStep == 1)
                <!-- Étape 1: Informations -->
                <h2 class="text-2xl font-semibold mb-6">Informations du profil</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" wire:model="full_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre du poste</label>
                        <input type="text" wire:model="job_title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                        <input type="text" wire:model="company"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                        <input type="text" wire:model="location"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea wire:model="bio" rows="4" maxlength="500"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <p class="text-sm text-gray-500 mt-1">{{ strlen($bio ?? '') }}/500 caractères</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" wire:model="phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                        <input type="url" wire:model="website"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

            @elseif($currentStep == 2)
                <!-- Étape 2: Design -->
                <h2 class="text-2xl font-semibold mb-6">Design du profil</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur du header</label>
                        <input type="color" wire:model.live="primary_color"
                            class="h-12 w-full rounded-lg cursor-pointer">
                    </div>

                    <!-- Aperçu header -->
                    <div class="border rounded-lg overflow-hidden">
                        <div class="h-32" style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                            <div class="h-full flex items-center justify-center">
                                <p class="text-white font-medium">Aperçu du header</p>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($currentStep == 3)
                <!-- Étape 3: Photo -->
                <h2 class="text-2xl font-semibold mb-6">Photo de profil</h2>

                <div class="space-y-6">
                    @if($photo)
                        <div class="flex justify-center">
                            <img src="{{ $photo->temporaryUrl() }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                        </div>
                    @else
                        <div class="flex justify-center">
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-4xl text-gray-400">📷</span>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Choisir une photo</label>
                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="flex justify-between mt-8 pt-6 border-t">
                @if($currentStep > 1)
                    <button wire:click="previousStep"
                        class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        ← Précédent
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < 3)
                    <button wire:click="nextStep"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Suivant →
                    </button>
                @else
                    <button wire:click="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        ✓ Créer le profil
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
