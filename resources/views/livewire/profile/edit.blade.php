<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Modifier le profil</h2>
        <p class="text-gray-600">Code: <span class="font-mono">{{ $profile->username }}</span></p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        
        <!-- Section: Informations -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📝 Informations</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                    <input type="text" wire:model="full_name" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                           required>
                    @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre du poste</label>
                    <input type="text" wire:model="job_title" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    @error('job_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                    <input type="text" wire:model="company" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    @error('company') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                    <input type="text" wire:model="location" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                           placeholder="Ville, Pays">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <textarea wire:model="bio" rows="3"
                              class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                              maxlength="500"></textarea>
                    @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" wire:model="phone" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site web</label>
                    <input type="url" wire:model.blur="website" 
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                           placeholder="https://example.com">
                    @error('website') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Section: Design -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🎨 Design</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Couleur du header</label>
                <div class="flex items-center gap-3">
                    <input type="color" wire:model.live="primary_color" 
                           class="h-12 w-24 border rounded cursor-pointer">
                    <span class="text-sm text-gray-600 font-mono">{{ $primary_color }}</span>
                </div>
            </div>

            <div class="mt-4 p-6 rounded-lg text-white text-center font-bold"
                 wire:key="header-preview-{{ $primary_color }}"
                 style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                Aperçu du header
            </div>
        </div>

        <!-- Section: Photo -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">📸 Photo de profil</h3>

            @if($photoPreview)
                <img src="{{ $photoPreview }}" class="w-32 h-32 rounded-full object-cover mb-4">
            @elseif($currentPhoto)
                <img src="{{ asset('storage/' . $currentPhoto) }}" class="w-32 h-32 rounded-full object-cover mb-4">
            @endif

            <input type="file" wire:model="photo" accept="image/*" class="block">
            <p class="text-sm text-gray-500 mt-1">JPG ou PNG, max 10MB</p>
            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Section: Username personnalisé (PRO/PREMIUM) -->
        @if($canEditUsername)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🔗 Username personnalisé</h3>
            <p class="text-sm text-gray-600 mb-3">Créez un lien personnalisé pour votre profil (ex: app.linkcard.ca/votrenom)</p>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username (3-30 caractères)</label>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">app.linkcard.ca/</span>
                    <input type="text" wire:model.blur="custom_username" 
                           class="border rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                           placeholder="{{ $profile->username }}">
                </div>
                @error('custom_username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="text-xs text-gray-500 mt-1">Laissez vide pour garder le code actuel</p>
            </div>
        </div>
        @endif

        <!-- Section: Liens sociaux -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🔗 Liens sociaux</h3>

            @if(session('link-success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-sm">
                    {{ session('link-success') }}
                </div>
            @endif

            @if(session('link-error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm">
                    {{ session('link-error') }}
                </div>
            @endif

            <!-- Indicateur limite -->
            <div class="mb-3 text-sm">
                <span class="font-medium">{{ count($links) }}/{{ $maxLinks }}</span> liens utilisés
                @if(!$canAddMoreLinks)
                    <span class="text-red-600 ml-2">⚠️ Limite atteinte pour le plan {{ auth()->user()->plan }}</span>
                @endif
            </div>

            @if(count($links) > 0)
                <div class="space-y-2 mb-4">
                    @foreach($links as $link)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded">
                            <span class="text-2xl">{{ \App\Models\Link::getPlatformIcon($link['platform']) }}</span>
                            <div class="flex-1">
                                <p class="font-medium capitalize">{{ $link['platform'] }}</p>
                                <p class="text-sm text-gray-600 truncate">{{ $link['url'] }}</p>
                            </div>
                            <button type="button" wire:click="deleteLink({{ $link['id'] }})" 
                                    class="text-red-600 hover:text-red-800">
                                🗑️
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm mb-4">Aucun lien ajouté</p>
            @endif

            @if($canAddMoreLinks)
                <div class="border-t pt-4">
                    <p class="font-medium mb-2">Ajouter un lien</p>
                    <div class="flex gap-2">
                        <select wire:model.live="newLinkPlatform" class="border rounded px-3 py-2">
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">LinkedIn</option>
                            <option value="twitter">Twitter/X</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                            <option value="github">GitHub</option>
                            <option value="website">Site web</option>
                            <option value="other">Autre</option>
                        </select>
                        <input type="url" wire:model.blur="newLinkUrl" 
                               placeholder="Collez votre lien ici..." 
                               class="flex-1 border rounded px-3 py-2">
                        <button type="button" wire:click="addLink" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-medium whitespace-nowrap">
                            + Ajouter
                        </button>
                    </div>
                    @error('newLinkUrl') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Collez l'URL complète (avec ou sans https://)</p>
                </div>
            @else
                <div class="border-t pt-4 bg-yellow-50 p-4 rounded">
                    <p class="text-sm text-gray-700">
                        🔒 Vous avez atteint la limite de liens pour votre plan <strong>{{ auth()->user()->plan }}</strong>.
                        @if(auth()->user()->plan === 'free')
                            Passez au plan PRO pour ajouter jusqu'à 10 liens.
                        @elseif(auth()->user()->plan === 'pro')
                            Passez au plan PREMIUM pour ajouter jusqu'à 20 liens.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Section: Galerie -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🖼️ Galerie d'images</h3>

            @if(session('gallery-success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded text-sm">
                    {{ session('gallery-success') }}
                </div>
            @endif

            @if(count($galleryImages) > 0)
                <div class="grid grid-cols-3 gap-4 mb-4">
                    @foreach($galleryImages as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image['path']) }}" 
                                 class="w-full h-32 object-contain bg-gray-100 rounded">
                            <button type="button" 
                                    wire:click="deleteImage({{ $image['id'] }})"
                                    class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-sm opacity-0 group-hover:opacity-100 transition">
                                🗑️
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm mb-4">Aucune image ajoutée</p>
            @endif

            <div class="border-t pt-4">
                <p class="font-medium mb-2">Ajouter des images</p>
                <input type="file" wire:model="newImages" multiple accept="image/*" class="block mb-2">
                <p class="text-sm text-gray-500 mb-2">Sélectionnez plusieurs images (max 10MB chacune)</p>
                @error('newImages.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                
                @if(count($newImages) > 0)
                    <div class="flex gap-2 mt-3">
                        <button type="button" wire:click="uploadImages" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium">
                            📤 Uploader {{ count($newImages) }} image(s)
                        </button>
                        <button type="button" wire:click="resetImages" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded font-medium">
                            ❌ Annuler sélection
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Boutons actions -->
        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                💾 Sauvegarder
            </button>
            <a href="{{ route('profile.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium inline-block">
                Annuler
            </a>
        </div>
    </form>
</div>
