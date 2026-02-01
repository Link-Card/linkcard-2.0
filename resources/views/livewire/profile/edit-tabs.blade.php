<div>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier le profil</h1>
            <p class="text-gray-600 mt-2">{{ $profile->full_name }}</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="switchTab('informations')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'informations' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        📋 Informations
                    </button>
                    <button wire:click="switchTab('design')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'design' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        🎨 Design
                    </button>
                    <button wire:click="switchTab('band')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'band' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        🖼️ Band
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-lg shadow p-6">
            @if($activeTab === 'informations')
                <!-- TAB 1: INFORMATIONS -->
                <div class="space-y-6">
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

                    <div class="flex justify-end pt-4 border-t">
                        <button wire:click="saveInformations" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Sauvegarder
                        </button>
                    </div>
                </div>

            @elseif($activeTab === 'design')
                <!-- TAB 2: DESIGN -->
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        
                        @if($profile->photo_path)
                            <div class="mb-4 flex justify-center">
                                <img src="{{ Storage::url($profile->photo_path) }}" 
                                    class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                            </div>
                        @endif

                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        
                        @if($photo)
                            <p class="text-sm text-green-600 mt-2">✓ Nouvelle photo sélectionnée</p>
                        @endif
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button wire:click="saveDesign" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Sauvegarder
                        </button>
                    </div>
                </div>

            @elseif($activeTab === 'band')
                <!-- TAB 3: BAND (Réseaux & Contenu) -->
                <div class="space-y-8">
                    
                    <!-- Contact Button Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Position Contact Button</label>
                        <input type="number" wire:model="contact_button_position" 
                            class="w-32 px-4 py-2 border border-gray-300 rounded-lg">
                        <span class="text-sm text-gray-500 ml-2">px</span>
                    </div>

                    <!-- Liens Sociaux -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">🔗 Liens sociaux</h3>
                        
                        <!-- Liste liens existants -->
                        @if(count($links) > 0)
                            <div class="space-y-2 mb-4">
                                @foreach($links as $link)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-2xl">🔗</span>
                                            <div>
                                                <p class="font-medium">{{ $link['platform'] }}</p>
                                                <p class="text-sm text-gray-500">{{ $link['url'] }}</p>
                                            </div>
                                        </div>
                                        <button wire:click="deleteLink({{ $link['id'] }})" 
                                            class="text-red-600 hover:text-red-700">
                                            🗑️
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Formulaire ajout -->
                        <div class="border-t pt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <select wire:model="newLinkPlatform" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">Sélectionner plateforme</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="LinkedIn">LinkedIn</option>
                                        <option value="Twitter">Twitter/X</option>
                                        <option value="TikTok">TikTok</option>
                                        <option value="YouTube">YouTube</option>
                                        <option value="GitHub">GitHub</option>
                                        <option value="Site web">Site web</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="url" wire:model="newLinkUrl" placeholder="https://..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                            <button wire:click="addLink" 
                                class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                + Ajouter lien
                            </button>
                        </div>
                    </div>

                    <!-- Bandes Images -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">🖼️ Bandes d'images</h3>
                        
                        @if(count($bands) > 0)
                            @foreach($bands as $band)
                                <div class="border rounded-lg p-4 mb-4">
                                    <h4 class="font-medium mb-3">Bande {{ $band['band_number'] }}</h4>
                                    <p class="text-sm text-gray-500">Gestion des images (à venir)</p>
                                </div>
                            @endforeach
                        @endif

                        <button wire:click="addBand" 
                            class="px-4 py-2 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 w-full text-gray-600 hover:text-indigo-600">
                            + Ajouter une bande
                        </button>
                    </div>

                    <!-- Bio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">📝 À propos / Bio</label>
                        <textarea wire:model="bio" rows="4" maxlength="500"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <p class="text-sm text-gray-500 mt-1">{{ strlen($bio ?? '') }}/500 caractères</p>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button wire:click="saveBand" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Terminer
                        </button>
                    </div>
                </div>
            @endif

            <!-- Messages succès/erreur -->
            @if(session()->has('success'))
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session()->has('link-success'))
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    {{ session('link-success') }}
                </div>
            @endif

            @if(session()->has('link-error'))
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                    {{ session('link-error') }}
                </div>
            @endif
        </div>

        <!-- Bouton Retour -->
        <div class="mt-6">
            <a href="{{ route('profile.index') }}" 
                class="text-gray-600 hover:text-gray-900">
                ← Retour à mes profils
            </a>
        </div>
    </div>
</div>
