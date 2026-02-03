<div>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <!-- Header Page -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">Modifier le profil</h1>
            <p class="mt-2 text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $profile->username }}</p>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl border mb-6" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="border-bottom: 1px solid #E5E7EB;">
                <nav class="flex -mb-px">
                    <button wire:click="switchTab('design')" 
                        class="px-6 py-4 text-sm font-medium transition"
                        style="font-family: 'Manrope', sans-serif; border-bottom: 2px solid {{ $activeTab === 'design' ? '#42B574' : 'transparent' }}; color: {{ $activeTab === 'design' ? '#42B574' : '#9CA3AF' }};"
                        onmouseover="if('{{ $activeTab }}' !== 'design') { this.style.color='#4B5563'; this.style.borderBottomColor='#D1D5DB'; }"
                        onmouseout="if('{{ $activeTab }}' !== 'design') { this.style.color='#9CA3AF'; this.style.borderBottomColor='transparent'; }">
                        🎨 Design
                    </button>
                    <button wire:click="switchTab('contenu')" 
                        class="px-6 py-4 text-sm font-medium transition"
                        style="font-family: 'Manrope', sans-serif; border-bottom: 2px solid {{ $activeTab === 'contenu' ? '#42B574' : 'transparent' }}; color: {{ $activeTab === 'contenu' ? '#42B574' : '#9CA3AF' }};"
                        onmouseover="if('{{ $activeTab }}' !== 'contenu') { this.style.color='#4B5563'; this.style.borderBottomColor='#D1D5DB'; }"
                        onmouseout="if('{{ $activeTab }}' !== 'contenu') { this.style.color='#9CA3AF'; this.style.borderBottomColor='transparent'; }">
                        📱 Contenu
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-xl border p-6" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            @if($activeTab === 'design')
                <!-- TAB DESIGN -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Couleur du header</label>
                        <input type="color" wire:model.live="primary_color" 
                            class="h-12 w-full rounded-lg cursor-pointer" style="border: 1.5px solid #D1D5DB;">
                    </div>

                    <!-- Aperçu header -->
                    <div class="rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB;">
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
                                <h2 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif;">{{ $full_name ?? 'Votre nom' }}</h2>
                                <p class="text-white/90" style="font-family: 'Manrope', sans-serif;">{{ $job_title ?? 'Votre titre' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4" style="border-top: 1px solid #E5E7EB;">
                        <button wire:click="saveDesign" 
                            class="px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; background: #42B574;"
                            onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'">
                            Sauvegarder
                        </button>
                    </div>
                </div>

            @elseif($activeTab === 'contenu')
                <!-- TAB CONTENU - Preview + Édition -->
                <div class="space-y-6">
                    
                    <!-- Preview du profil -->
                    <div class="max-w-md mx-auto rounded-xl overflow-y-auto max-h-[800px]" style="border: 2px dashed #D1D5DB;">
                        
                        <!-- Header (cliquable) -->
                        <div wire:click="openHeaderModal" 
                            class="relative cursor-pointer group"
                            style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover:opacity-100 transition text-sm font-medium" style="font-family: 'Manrope', sans-serif;">
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
                                <h2 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif;">{{ $full_name }}</h2>
                                @if($job_title)
                                    <p class="text-white/90" style="font-family: 'Manrope', sans-serif;">{{ $job_title }}</p>
                                @endif
                                @if($company)
                                    <p class="text-sm text-white/80" style="font-family: 'Manrope', sans-serif;">{{ $company }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="bg-white p-6 space-y-3 text-sm" style="font-family: 'Manrope', sans-serif;">
                            @if($phone)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">📞</span>
                                    <span style="color: #2C2A27;">{{ $phone }}</span>
                                </div>
                            @endif
                            @if($email)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">✉️</span>
                                    <span style="color: #2C2A27;">{{ $email }}</span>
                                </div>
                            @endif
                            @if($website)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">🌐</span>
                                    <span class="truncate" style="color: #2C2A27;">{{ $website }}</span>
                                </div>
                            @endif
                            @if($location)
                                <div class="flex items-center space-x-3">
                                    <span class="text-xl">📍</span>
                                    <span style="color: #2C2A27;">{{ $location }}</span>
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
                                        <div class="flex items-center justify-between p-4 rounded-lg" style="background: #F3F4F6; border: 1px solid #E5E7EB;">
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
                                                <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $band['data']['platform'] }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4A7FBF;" 
                                                    onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'" title="Modifier">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'" title="Monter">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'" title="Descendre">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #EF4444;"
                                                    onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Image -->
                                    @if($band['type'] === 'image')
                                        <div class="relative group">
                                            <img src="{{ Storage::url($band['data']['path']) }}" 
                                                class="w-full rounded-lg object-cover" style="max-height: 300px;">
                                            @if($band['data']['link'] ?? false)
                                                <div class="absolute top-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded" style="font-family: 'Manrope', sans-serif;">🔗 Lien</div>
                                            @endif
                                            <div class="absolute top-2 right-2 flex space-x-1 bg-white rounded-lg shadow-md">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4A7FBF;"
                                                    onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #EF4444;"
                                                    onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Contact Button -->
                                    @if($band['type'] === 'contact_button')
                                        <div class="relative">
                                            <button class="w-full py-3 px-6 rounded-lg font-medium text-white shadow-md" style="font-family: 'Manrope', sans-serif; background-color: {{ $primary_color }};">
                                                ☎️ {{ $band['data']['text'] }}
                                            </button>
                                            <div class="absolute top-1 right-1 flex space-x-1 bg-white rounded-lg shadow-md">
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-xs transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-xs transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-xs transition-colors" style="color: #EF4444;"
                                                    onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">🗑️</button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Text Block -->
                                    @if($band['type'] === 'text_block')
                                        <div class="relative p-4 rounded-lg" style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                                            <p class="whitespace-pre-line pr-20" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $band['data']['text'] }}</p>
                                            <div class="absolute top-2 right-2 flex space-x-1 bg-white rounded-lg shadow-md">
                                                <button wire:click="editBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4A7FBF;"
                                                    onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'">✏️</button>
                                                <button wire:click="moveBandUp({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↑</button>
                                                <button wire:click="moveBandDown({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #4B5563;"
                                                    onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">↓</button>
                                                <button wire:click="deleteBand({{ $band['id'] }})" 
                                                    class="p-1.5 rounded text-sm transition-colors" style="color: #EF4444;"
                                                    onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">🗑️</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="py-8 text-center">
                                    <p class="mb-2" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Aucun contenu ajouté</p>
                                    <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #D1D5DB;">Cliquez sur "+" ci-dessous pour commencer</p>
                                </div>
                            @endforelse

                            <!-- Bouton Ajouter une bande -->
                            <div class="pt-4">
                                <div x-data="{ showDropdown: false }" class="relative">
                                    <button 
                                        @click="showDropdown = !showDropdown"
                                        type="button"
                                        class="w-full px-4 py-3 border-2 border-dashed rounded-lg font-medium text-center transition-colors"
                                        style="font-family: 'Manrope', sans-serif; border-color: #D1D5DB; color: #4B5563;"
                                        onmouseover="this.style.borderColor='#42B574'; this.style.color='#42B574'"
                                        onmouseout="this.style.borderColor='#D1D5DB'; this.style.color='#4B5563'">
                                        ➕ Ajouter une bande
                                    </button>

                                    <div 
                                        x-show="showDropdown" 
                                        @click.away="showDropdown = false"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        class="absolute left-0 right-0 mt-2 bg-white rounded-xl overflow-hidden z-10"
                                        style="box-shadow: 0 12px 32px rgba(0,0,0,0.16); border: 1px solid #E5E7EB; display: none;">
                                        
                                        @if($availableTypes['social_link']['available'])
                                            <button 
                                                wire:click="openAddBandModal('social_link')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 flex items-center justify-between transition-colors"
                                                style="font-family: 'Manrope', sans-serif; border-bottom: 1px solid #F3F4F6;"
                                                onmouseover="this.style.background='#F0F9F4'"
                                                onmouseout="this.style.background='transparent'">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">🔗</span>
                                                    <span class="font-medium text-sm" style="color: #2C2A27;">Lien social</span>
                                                </div>
                                                <span class="text-xs" style="color: #9CA3AF;">{{ $availableTypes['social_link']['remaining'] }} restant(s)</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['image']['available'])
                                            <button 
                                                wire:click="openAddBandModal('image')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 flex items-center justify-between transition-colors"
                                                style="font-family: 'Manrope', sans-serif; border-bottom: 1px solid #F3F4F6;"
                                                onmouseover="this.style.background='#F0F9F4'"
                                                onmouseout="this.style.background='transparent'">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">🖼️</span>
                                                    <span class="font-medium text-sm" style="color: #2C2A27;">Image</span>
                                                </div>
                                                <span class="text-xs" style="color: #9CA3AF;">{{ $availableTypes['image']['remaining'] }} restante(s)</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['contact_button']['available'])
                                            <button 
                                                wire:click="openAddBandModal('contact_button')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 flex items-center justify-between transition-colors"
                                                style="font-family: 'Manrope', sans-serif; border-bottom: 1px solid #F3F4F6;"
                                                onmouseover="this.style.background='#F0F9F4'"
                                                onmouseout="this.style.background='transparent'">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">☎️</span>
                                                    <span class="font-medium text-sm" style="color: #2C2A27;">Bouton contact</span>
                                                </div>
                                                <span class="text-xs" style="color: #9CA3AF;">{{ $availableTypes['contact_button']['remaining'] }} restant</span>
                                            </button>
                                        @endif
                                        
                                        @if($availableTypes['text_block']['available'])
                                            <button 
                                                wire:click="openAddBandModal('text_block')"
                                                @click="showDropdown = false"
                                                type="button"
                                                class="w-full text-left px-4 py-3 flex items-center justify-between transition-colors"
                                                style="font-family: 'Manrope', sans-serif;"
                                                onmouseover="this.style.background='#F0F9F4'"
                                                onmouseout="this.style.background='transparent'">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-2xl">📝</span>
                                                    <span class="font-medium text-sm" style="color: #2C2A27;">Texte</span>
                                                </div>
                                                <span class="text-xs" style="color: #9CA3AF;">{{ $availableTypes['text_block']['remaining'] }} restant(s)</span>
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
                <div class="mt-4 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="mt-4 p-4 rounded-lg text-sm font-medium" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Bouton Retour -->
        <div class="mt-6">
            <a href="{{ route('profile.index') }}" 
                class="text-sm font-medium transition-colors"
                style="font-family: 'Manrope', sans-serif; color: #42B574;"
                onmouseover="this.style.color='#3DA367'"
                onmouseout="this.style.color='#42B574'">
                ← Retour à mes profils
            </a>
        </div>
    </div>

    <!-- Modal Header -->
    @if($showHeaderModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" style="backdrop-filter: blur(4px);">
            <div class="bg-white rounded-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto" style="box-shadow: 0 12px 32px rgba(0,0,0,0.16);">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">✏️ Modifier les informations</h3>
                    <button wire:click="closeHeaderModal" class="text-2xl transition-colors" style="color: #9CA3AF;"
                            onmouseover="this.style.color='#4B5563'" onmouseout="this.style.color='#9CA3AF'">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nom complet *</label>
                        <input type="text" wire:model="full_name" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                        @error('full_name') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Titre / Poste</label>
                        <input type="text" wire:model="job_title" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Entreprise</label>
                        <input type="text" wire:model="company" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Localisation</label>
                        <input type="text" wire:model="location" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Email</label>
                        <input type="email" wire:model="email" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Téléphone</label>
                        <input type="tel" wire:model="phone" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Site web</label>
                        <input type="url" wire:model="website" 
                            class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                            onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                            onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Photo de profil</label>
                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-lg"
                            style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;">
                        @error('photo') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                    </div>
                    <button wire:click="saveHeader" 
                        class="w-full px-4 py-2.5 text-white rounded-lg font-medium transition-all duration-200 mt-2"
                        style="font-family: 'Manrope', sans-serif; background: #42B574; font-size: 14px;"
                        onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'">
                        Sauvegarder
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Ajouter/Éditer Bande -->
    @if($showAddBandModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" style="backdrop-filter: blur(4px);">
            <div class="bg-white rounded-xl max-w-md w-full p-6" style="box-shadow: 0 12px 32px rgba(0,0,0,0.16);">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
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
                    <button wire:click="closeAddBandModal" class="text-2xl transition-colors" style="color: #9CA3AF;"
                            onmouseover="this.style.color='#4B5563'" onmouseout="this.style.color='#9CA3AF'">✕</button>
                </div>

                <!-- Formulaire Social Link -->
                @if($newBandType === 'social_link')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Plateforme</label>
                            <select wire:model="newSocialPlatform" 
                                class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                                style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                                onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                                onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
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
                            @error('newSocialPlatform') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">URL</label>
                            <input type="url" wire:model="newSocialUrl" placeholder="facebook.com"
                                class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                                style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                                onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                                onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                            @error('newSocialUrl') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addSocialLink" 
                            class="w-full px-4 py-2.5 text-white rounded-lg font-medium transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; background: #42B574; font-size: 14px;"
                            onmouseover="this.style.background='#3DA367'"
                            onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- Formulaire Image -->
                @if($newBandType === 'image')
                    <div class="space-y-4">
                        @if($editingBandId && $currentImagePath)
                            <div>
                                <p class="text-sm mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Image actuelle:</p>
                                <img src="{{ Storage::url($currentImagePath) }}" 
                                    class="w-full h-40 object-cover rounded-lg" style="border: 1px solid #E5E7EB;">
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                                {{ $editingBandId ? 'Nouvelle image (optionnel)' : 'Image' }}
                            </label>
                            <input type="file" wire:model="newImage" accept="image/*"
                                class="w-full px-4 py-2.5 rounded-lg"
                                style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;">
                            @error('newImage') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        @if($availableTypes['image_url_allowed'])
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Lien (optionnel)</label>
                                <input type="url" wire:model="newImageLink" placeholder="linkcard.ca"
                                    class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                                    style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                                    onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                            </div>
                        @else
                            <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">💡 Les liens sur images sont disponibles avec Pro/Premium</p>
                        @endif
                        <button wire:click="addImage" 
                            class="w-full px-4 py-2.5 text-white rounded-lg font-medium transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; background: #42B574; font-size: 14px;"
                            onmouseover="this.style.background='#3DA367'"
                            onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- Formulaire Contact Button -->
                @if($newBandType === 'contact_button')
                    <div class="space-y-4">
                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                            Ce bouton permettra aux visiteurs d'enregistrer vos coordonnées.
                        </p>
                        <button wire:click="addContactButton" 
                            class="w-full px-4 py-2.5 text-white rounded-lg font-medium transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; background: #42B574; font-size: 14px;"
                            onmouseover="this.style.background='#3DA367'"
                            onmouseout="this.style.background='#42B574'">
                            Ajouter
                        </button>
                    </div>
                @endif

                <!-- Formulaire Text Block -->
                @if($newBandType === 'text_block')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Texte</label>
                            <div x-data="{ charCount: 0 }">
                                <textarea 
                                    wire:model="newTextContent" 
                                    @input="charCount = $el.value.length"
                                    x-init="charCount = $el.value.length"
                                    rows="6" 
                                    maxlength="500"
                                    class="w-full px-4 py-2.5 rounded-lg transition-all duration-200"
                                    style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;"
                                    onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"></textarea>
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                    <span x-text="charCount"></span>/500 caractères
                                </p>
                            </div>
                            @error('newTextContent') <span class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addTextBlock" 
                            class="w-full px-4 py-2.5 text-white rounded-lg font-medium transition-all duration-200"
                            style="font-family: 'Manrope', sans-serif; background: #42B574; font-size: 14px;"
                            onmouseover="this.style.background='#3DA367'"
                            onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
