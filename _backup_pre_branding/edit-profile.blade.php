<div>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier le profil</h1>
            <p class="text-gray-600 mt-2">{{ $profile->username }}</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="switchTab('design')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 transition {{ $activeTab === 'design' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        🎨 Design
                    </button>
                    <button wire:click="switchTab('contenu')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 transition {{ $activeTab === 'contenu' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        📱 Contenu
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-lg shadow p-6">
            @if($activeTab === 'design')
                <!-- TAB DESIGN -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur du header</label>
                        <input type="color" wire:model.live="primary_color" 
                            class="h-12 w-full rounded-lg cursor-pointer border border-gray-300">
                    </div>

                    <!-- Aperçu header -->
                    <div class="border rounded-lg overflow-hidden">
                        <div class="h-48 relative" style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-6">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" 
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg mb-4">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-white/30 border-4 border-white shadow-lg mb-4 flex items-center justify-center">
                                        <span class="text-4xl">👤</span>
                                    </div>
                                @endif
                                <h2 class="text-2xl font-bold">{{ $full_name ?? 'Votre nom' }}</h2>
                                <p class="text-white/90">{{ $job_title ?? 'Votre titre' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button wire:click="saveDesign" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Sauvegarder
                        </button>
                    </div>
                </div>

            @elseif($activeTab === 'contenu')
                <!-- TAB CONTENU - Preview + Édition -->
                <div class="space-y-6">
                    
                    <!-- Preview du profil -->
                    <div class="max-w-md mx-auto border-2 border-dashed border-gray-300 rounded-lg overflow-y-auto max-h-[800px]">
                        
                        <!-- Header (cliquable) -->
                        <div wire:click="openHeaderModal" 
                            class="relative cursor-pointer group"
                            style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover:opacity-100 transition text-sm font-medium">
                                    ✏️ Cliquer pour modifier
                                </span>
                            </div>
                            <div class="relative p-6 text-center text-white">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" 
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg mx-auto mb-4">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-white/30 border-4 border-white shadow-lg mx-auto mb-4 flex items-center justify-center">
                                        <span class="text-4xl">👤</span>
                                    </div>
                                @endif
                                <h2 class="text-2xl font-bold">{{ $full_name }}</h2>
                                @if($job_title)
                                    <p class="text-white/90">{{ $job_title }}</p>
                                @endif
                                @if($company)
                                    <p class="text-sm text-white/80">{{ $company }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="bg-white p-6 space-y-3 text-sm">
                            @if($phone)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">📞</span>
                                    <span>{{ $phone }}</span>
                                </div>
                            @endif
                            @if($email)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">✉️</span>
                                    <span>{{ $email }}</span>
                                </div>
                            @endif
                            @if($website)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">🌐</span>
                                    <span class="truncate">{{ $website }}</span>
                                </div>
                            @endif
                            @if($location)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">📍</span>
                                    <span>{{ $location }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Bandes de contenu -->
                        <div class="bg-white px-6 pb-6 space-y-4">
                            @forelse($contentBands as $index => $band)
                                <!-- Bande -->
                                <div>
                                    <!-- Social Link -->
                                    @if($band['type'] === 'social_link')
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-2xl">
                                                    @if($band['data']['platform'] === 'Facebook') 🔵
                                                    @elseif($band['data']['platform'] === 'Instagram') 📷
                                                    @elseif($band['data']['platform'] === 'LinkedIn') 💼
                                                    @elseif($band['data']['platform'] === 'Twitter') 🐦
                                                    @elseif($band['data']['platform'] === 'TikTok') 🎵
                                                    @elseif($band['data']['platform'] === 'YouTube') ▶️
                                                    @elseif($band['data']['platform'] === 'GitHub') 💻
                                                    @else 🔗
                                                    @endif
                                                </span>
                                                <span class="font-medium">{{ $band['data']['platform'] }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded text-sm" title="Modifier">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm" title="Monter">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm" title="Descendre">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded text-sm" title="Supprimer">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Image -->
                                    @if($band['type'] === 'image')
                                        <div class="relative group">
                                            <img src="{{ Storage::url($band['data']['path']) }}" 
                                                class="w-full rounded-lg object-cover" style="max-height: 300px;">
                                            @if($band['data']['link'] ?? false)
                                                <div class="absolute top-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded">🔗 Lien</div>
                                            @endif
                                            <div class="absolute top-2 right-2 flex space-x-1 bg-white rounded shadow">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded text-sm">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded text-sm">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Contact Button -->
                                    @if($band['type'] === 'contact_button')
                                        <div class="relative">
                                            <button class="w-full py-3 px-6 rounded-lg font-medium text-white shadow-lg"
                                                style="background-color: {{ $primary_color }};">
                                                ☎️ {{ $band['data']['text'] }}
                                            </button>
                                            <div class="absolute top-1 right-1 flex space-x-1 bg-white rounded shadow">
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-xs">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-xs">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded text-xs">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Text Block -->
                                    @if($band['type'] === 'text_block')
                                        <div class="relative p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <p class="text-gray-700 whitespace-pre-line pr-20">{{ $band['data']['text'] }}</p>
                                            <div class="absolute top-2 right-2 flex space-x-1 bg-white rounded shadow">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-blue-600 hover:bg-blue-50 rounded text-sm">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 text-gray-600 hover:bg-gray-100 rounded text-sm">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 text-red-600 hover:bg-red-50 rounded text-sm">🗑️</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="py-8 text-center text-gray-500">
                                    <p class="mb-2">Aucun contenu ajouté</p>
                                    <p class="text-sm">Cliquez sur "+" ci-dessous pour commencer</p>
                                </div>
                            @endforelse

                            <!-- Bouton Ajouter une bande -->
                            <div class="pt-4">
                                <div x-data="{ showDropdown: false }" class="relative">
                                    <button 
                                        @click="showDropdown = !showDropdown"
                                        type="button"
                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-indigo-500 hover:text-indigo-600 transition font-medium text-center">
                                        ➕ Ajouter une bande
                                    </button>

                                    <div 
                                        x-show="showDropdown" 
                                        @click.away="showDropdown = false"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        class="absolute left-0 right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 z-10 overflow-hidden"
                                        style="display: none;">
                                        
                                        @if($availableTypes['social_link']['available'])
                                            <button 
                                                wire:click="openAddBandModal('social_link')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center justify-between border-b">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">🔗</span>
                                                    <span class="font-medium">Lien social</span>
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $availableTypes['social_link']['remaining'] }} restant(s)</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['image']['available'])
                                            <button 
                                                wire:click="openAddBandModal('image')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center justify-between border-b">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">🖼️</span>
                                                    <span class="font-medium">Image</span>
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $availableTypes['image']['remaining'] }} restante(s)</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['contact_button']['available'])
                                            <button 
                                                wire:click="openAddBandModal('contact_button')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center justify-between border-b">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">☎️</span>
                                                    <span class="font-medium">Bouton contact</span>
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $availableTypes['contact_button']['remaining'] }} restant</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['text_block']['available'])
                                            <button 
                                                wire:click="openAddBandModal('text_block')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">📝</span>
                                                    <span class="font-medium">Texte</span>
                                                </div>
                                                <span class="text-xs text-gray-500">{{ $availableTypes['text_block']['remaining'] }} restant(s)</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Messages -->
            @if(session()->has('success'))
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                    {{ session('error') }}
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

    <!-- Modal Header -->
    @if($showHeaderModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">✏️ Modifier les informations</h3>
                    <button wire:click="closeHeaderModal" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" wire:model="full_name" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre / Poste</label>
                        <input type="text" wire:model="job_title" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                        <input type="text" wire:model="company" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                        <input type="text" wire:model="location" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" wire:model="email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" wire:model="phone" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                        <input type="url" wire:model="website" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <button wire:click="saveHeader" 
                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Ajouter/Éditer Bande -->
    @if($showAddBandModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        @if($editingBandId)
                            @if($newBandType === 'social_link') ✏️ Modifier le lien
                            @elseif($newBandType === 'image') ✏️ Modifier l'image
                            @elseif($newBandType === 'text_block') ✏️ Modifier le texte
                            @endif
                        @else
                            @if($newBandType === 'social_link') 🔗 Ajouter un lien social
                            @elseif($newBandType === 'image') 🖼️ Ajouter une image
                            @elseif($newBandType === 'contact_button') ☎️ Ajouter bouton contact
                            @elseif($newBandType === 'text_block') 📝 Ajouter un texte
                            @endif
                        @endif
                    </h3>
                    <button wire:click="closeAddBandModal" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
                </div>

                <!-- Formulaire Social Link -->
                @if($newBandType === 'social_link')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plateforme</label>
                            <select wire:model="newSocialPlatform" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Sélectionner</option>
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
                            @error('newSocialPlatform') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                            <input type="url" wire:model="newSocialUrl" placeholder="facebook.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            @error('newSocialUrl') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addSocialLink" 
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- Formulaire Image -->
                @if($newBandType === 'image')
                    <div class="space-y-4">
                        @if($editingBandId && $currentImagePath)
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Image actuelle:</p>
                                <img src="{{ Storage::url($currentImagePath) }}" 
                                    class="w-full h-40 object-cover rounded-lg border">
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $editingBandId ? 'Nouvelle image (optionnel)' : 'Image' }}
                            </label>
                            <input type="file" wire:model="newImage" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @if($availableTypes['image_url_allowed'])
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lien (optionnel)</label>
                                <input type="url" wire:model="newImageLink" placeholder="linkcard.ca"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        @else
                            <p class="text-sm text-gray-500">💡 Les liens sur images sont disponibles avec Pro/Premium</p>
                        @endif
                        <button wire:click="addImage" 
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- Formulaire Contact Button -->
                @if($newBandType === 'contact_button')
                    <div class="space-y-4">
                        <p class="text-sm text-gray-600">
                            Ce bouton permettra aux visiteurs d'enregistrer vos coordonnées.
                        </p>
                        <button wire:click="addContactButton" 
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Ajouter
                        </button>
                    </div>
                @endif

                <!-- Formulaire Text Block -->
                @if($newBandType === 'text_block')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Texte</label>
                            <div x-data="{ charCount: 0 }">
                                <textarea 
                                    wire:model="newTextContent" 
                                    @input="charCount = $el.value.length"
                                    x-init="charCount = $el.value.length"
                                    rows="6" 
                                    maxlength="500"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span x-text="charCount"></span>/500 caractères
                                </p>
                            </div>
                            @error('newTextContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addTextBlock" 
                            class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
