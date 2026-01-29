<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Créer un profil</h1>
            <p class="mt-2 text-sm text-gray-600">Étape {{ $currentStep }} sur 3</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="relative">
                        <div class="h-2 bg-gray-200 rounded-full">
                            <div class="h-2 bg-green-600 rounded-full transition-all duration-300" 
                                 style="width: {{ ($currentStep / 3) * 100 }}%"></div>
                        </div>
                        <div class="mt-2 flex justify-between text-xs text-gray-600">
                            <span class="{{ $currentStep >= 1 ? 'font-bold text-green-600' : '' }}">Informations</span>
                            <span class="{{ $currentStep >= 2 ? 'font-bold text-green-600' : '' }}">Design</span>
                            <span class="{{ $currentStep >= 3 ? 'font-bold text-green-600' : '' }}">Éléments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            @if($currentStep === 1)
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de base</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="full_name" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ex: Mathieu Corbeil">
                        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre professionnel</label>
                        <input type="text" wire:model="job_title" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ex: Développeur Web">
                        @error('job_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                        <input type="text" wire:model="company" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ex: Link-Card Inc.">
                        @error('company') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                        <input type="text" wire:model="location" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ex: Montréal, QC">
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio (500 caractères max)</label>
                        <textarea wire:model="bio" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                  placeholder="Parlez de vous..."></textarea>
                        <p class="text-sm text-gray-500 mt-1">{{ strlen($bio) }}/500 caractères</p>
                        @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" wire:model="email" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="contact@example.com">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" wire:model="phone" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="+1 (123) 456-7890">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                        <input type="text" wire:model.blur="website" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="example.com">
                        <p class="text-xs text-gray-500 mt-1">💡 https:// sera ajouté automatiquement</p>
                        @error('website') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('profile.index') }}"
                           class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-150">
                            Annuler
                        </a>
                        <button type="button" wire:click="nextStep"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-150">
                            Suivant →
                        </button>
                    </div>
                </div>
            @endif

            @if($currentStep === 2)
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Choisir le design</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Template</label>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="border-2 border-green-500 rounded-lg p-4 bg-green-50">
                                <h3 class="font-semibold text-gray-900">Template Classique</h3>
                                <p class="text-sm text-gray-600 mt-1">Design professionnel avec header dégradé</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded-full">Sélectionné</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur du header</label>
                        <div class="flex items-center space-x-4">
                            <input type="color" wire:model.live="primary_color" 
                                   class="h-12 w-20 border border-gray-300 rounded cursor-pointer">
                            <input type="text" wire:model.live="primary_color" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg"
                                   placeholder="#2D7A4F">
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Couleur actuelle: {{ $primary_color }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aperçu</label>
                        <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                            <div class="h-32" style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%)"></div>
                            <div class="p-6 text-center">
                                <div class="w-20 h-20 mx-auto bg-gray-300 rounded-full -mt-16 border-4 border-white"></div>
                                <h3 class="mt-4 font-bold text-gray-900">{{ $full_name ?: 'Votre nom' }}</h3>
                                <p class="text-sm text-gray-600">{{ $job_title ?: 'Votre titre' }}</p>
                                @if($location)
                                    <p class="text-xs text-gray-500 mt-1">📍 {{ $location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <button type="button" wire:click="previousStep"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-150">
                            ← Retour
                        </button>
                        <button type="button" wire:click="nextStep"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-150">
                            Suivant →
                        </button>
                    </div>
                </div>
            @endif

            @if($currentStep === 3)
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ajouter des éléments</h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        <input type="file" wire:model="photo" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        
                        @if ($photo)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Aperçu:</p>
                                <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                            </div>
                        @endif
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <p class="text-sm text-blue-700">
                            <strong>Note:</strong> Les liens sociaux et images de galerie pourront être ajoutés après la création du profil.
                        </p>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <button type="button" wire:click="previousStep"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-150">
                            ← Retour
                        </button>
                        <button type="button" wire:click="save"
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-150">
                            ✓ Créer le profil
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
