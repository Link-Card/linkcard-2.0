<div x-data="{ savedShow: false }" @auto-saved.window="savedShow = true; setTimeout(() => savedShow = false, 2000)">

    <!-- ========== PAGE HEADER ========== -->
    <div class="max-w-7xl mx-auto pt-6 pb-4 px-4 sm:px-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">
                    Modifier le profil
                </h1>
                <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                    {{ $profile->username }}
                    <span class="mx-1">·</span>
                    <a href="{{ route('profile.public', $profile->username) }}" target="_blank"
                       class="transition" style="color: #42B574;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">
                        Voir le profil public ↗
                    </a>
                </p>
            </div>
            <div x-show="savedShow" x-transition.opacity.duration.300ms
                 class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full"
                 style="background: #F0F9F4; color: #42B574; font-family: 'Manrope', sans-serif; font-size: 13px; font-weight: 500;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Sauvegardé</span>
            </div>
        </div>
    </div>

    <!-- ========== MAIN LAYOUT ========== -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 flex gap-6">

        <!-- ==================== LEFT: EDITOR ==================== -->
        <div class="w-[58%] space-y-4">

            <!-- ===== SECTION 1: HEADER (collapsible) ===== -->
            <div x-data="{ open: false }"
                 class="bg-white rounded-xl overflow-hidden"
                 style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 transition-colors"
                        style="font-family: 'Manrope', sans-serif;"
                        :style="open ? 'background: #FAFAFA' : ''">
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">📷</span>
                        <span class="font-medium text-sm" style="color: #2C2A27;">Photo, Nom & Couleur</span>
                    </div>
                    <svg class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9CA3AF;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition style="border-top: 1px solid #E5E7EB;">
                    <div class="px-5 py-5 space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Photo de profil</label>
                            <div class="flex items-center space-x-4">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-16 h-16 rounded-full object-cover" style="border: 2px solid #E5E7EB;">
                                @else
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: #F3F4F6; border: 2px solid #E5E7EB;">
                                        <span class="text-2xl">👤</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" wire:model="photo" accept="image/*" class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                                    <div wire:loading wire:target="photo" class="flex items-center space-x-1 mt-1">
                                        <svg class="animate-spin h-3 w-3" style="color: #42B574;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                        <span class="text-xs" style="color: #9CA3AF;">Upload en cours...</span>
                                    </div>
                                    @error('photo') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nom complet *</label>
                            <input type="text" wire:model.live.debounce.500ms="full_name" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                            @error('full_name') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Titre / Poste</label>
                            <input type="text" wire:model.live.debounce.500ms="job_title" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Entreprise</label>
                            <input type="text" wire:model.live.debounce.500ms="company" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Localisation</label>
                            <input type="text" wire:model.live.debounce.500ms="location" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Couleur du header</label>
                            <input type="color" wire:model.live.debounce.500ms="primary_color" class="h-11 w-full rounded-lg cursor-pointer" style="border: 1.5px solid #D1D5DB;">
                        </div>
                        <button @click="open = false" class="w-full py-2.5 rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;" onmouseover="this.style.background='#42B574'; this.style.color='#FFFFFF'" onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                            ✓ Valider
                        </button>
                    </div>
                </div>
            </div>

            <!-- ===== SECTION 2: INFOS CONTACT (collapsible) ===== -->
            <div x-data="{ open: false }"
                 class="bg-white rounded-xl overflow-hidden"
                 style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 transition-colors"
                        style="font-family: 'Manrope', sans-serif;"
                        :style="open ? 'background: #FAFAFA' : ''">
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">⚙️</span>
                        <span class="font-medium text-sm" style="color: #2C2A27;">Infos contact</span>
                    </div>
                    <svg class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9CA3AF;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-transition style="border-top: 1px solid #E5E7EB;">
                    <div class="px-5 py-5 space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Email</label>
                            <input type="email" wire:model.live.debounce.500ms="email" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                            @error('email') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Téléphone</label>
                            <input type="tel" wire:model.live.debounce.500ms="phone" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Site web</label>
                            <input type="url" wire:model.live.debounce.500ms="website" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                            @error('website') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Bio</label>
                            <div x-data="{ charCount: 0 }">
                                <textarea wire:model.live.debounce.500ms="bio" @input="charCount = $el.value.length" x-init="charCount = $el.value.length" rows="3" maxlength="500" class="w-full px-4 py-2.5 rounded-lg transition-all duration-200" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px; resize: vertical;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"></textarea>
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;"><span x-text="charCount"></span>/500 caractères</p>
                            </div>
                        </div>
                        <button @click="open = false" class="w-full py-2.5 rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;" onmouseover="this.style.background='#42B574'; this.style.color='#FFFFFF'" onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                            ✓ Valider
                        </button>
                    </div>
                </div>
            </div>

            <!-- ===== SECTION 3: BOUTON CONTACT (toggle) ===== -->
            <div class="bg-white rounded-xl overflow-hidden px-5 py-4 flex items-center justify-between"
                 style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="flex items-center space-x-3">
                    <span class="text-lg">📇</span>
                    <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Bouton "Ajouter aux contacts"</span>
                </div>
                <button wire:click="toggleContactButton"
                        class="relative w-12 h-7 rounded-full transition-colors duration-200 focus:outline-none"
                        style="background: {{ $hasContactButton ? '#42B574' : '#D1D5DB' }};">
                    <span class="absolute top-0.5 left-0.5 w-6 h-6 bg-white rounded-full shadow transition-transform duration-200"
                          style="transform: translateX({{ $hasContactButton ? '20px' : '0px' }});"></span>
                </button>
            </div>

            <!-- ===== SECTION 4: BANDES (drag & drop) ===== -->
            <div class="bg-white rounded-xl overflow-hidden"
                 style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="px-5 py-4" style="border-bottom: 1px solid #E5E7EB;">
                    <h3 class="font-medium text-sm flex items-center space-x-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                        <span>📱</span><span>Contenu du profil</span>
                    </h3>
                </div>
                <div class="p-4">
                    <div id="bands-list" class="space-y-2 min-h-[20px]">
                        @forelse($editableBands as $index => $band)
                            <div data-band-id="{{ $band['id'] }}"
                                 class="flex items-center p-3 rounded-lg transition-all duration-150 group"
                                 style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                                <span class="drag-handle cursor-grab active:cursor-grabbing mr-3 text-base select-none" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'" onmouseout="this.style.color='#9CA3AF'">≡</span>
                                <span class="mr-3 w-6 text-center text-lg">
                                    @if($band['type'] === 'social_link')
                                        @php $p = $band['data']['platform'] ?? ''; @endphp
                                        @if($p === 'Facebook') <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                        @elseif($p === 'Instagram') <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                        @elseif($p === 'LinkedIn') <i class="fab fa-linkedin" style="color: #0A66C2;"></i>
                                        @elseif($p === 'Twitter') <i class="fab fa-x-twitter" style="color: #000;"></i>
                                        @elseif($p === 'TikTok') <i class="fab fa-tiktok" style="color: #000;"></i>
                                        @elseif($p === 'YouTube') <i class="fab fa-youtube" style="color: #FF0000;"></i>
                                        @elseif($p === 'GitHub') <i class="fab fa-github" style="color: #181717;"></i>
                                        @else <i class="fas fa-link" style="color: #6B7280;"></i>
                                        @endif
                                    @elseif($band['type'] === 'image') <i class="fas fa-image" style="color: #6B7280;"></i>
                                    @elseif($band['type'] === 'text_block') <i class="fas fa-align-left" style="color: #6B7280;"></i>
                                    @endif
                                </span>
                                <span class="flex-1 text-sm font-medium truncate" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                                    @if($band['type'] === 'social_link') {{ $band['data']['platform'] ?? 'Lien social' }}
                                    @elseif($band['type'] === 'image') Image
                                    @elseif($band['type'] === 'text_block') {{ Str::limit($band['data']['text'] ?? 'Texte', 30) }}
                                    @endif
                                </span>
                                <div class="flex items-center space-x-1 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="editBand({{ $band['id'] }})" class="p-1.5 rounded transition-colors" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'" title="Modifier">
                                        <span class="text-sm">✏️</span>
                                    </button>
                                    <button wire:click="deleteBand({{ $band['id'] }})" wire:confirm="Supprimer cette bande ?" class="p-1.5 rounded transition-colors" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer">
                                        <span class="text-sm">🗑️</span>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <p class="mb-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Aucun contenu ajouté</p>
                                <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #D1D5DB;">Cliquez ci-dessous pour commencer</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-3">
                        <button wire:click="openAddBandModal" class="w-full py-3 border-2 border-dashed rounded-lg font-medium text-sm text-center transition-all duration-200" style="font-family: 'Manrope', sans-serif; border-color: #D1D5DB; color: #4B5563;" onmouseover="this.style.borderColor='#42B574'; this.style.color='#42B574'" onmouseout="this.style.borderColor='#D1D5DB'; this.style.color='#4B5563'">
                            ＋ Ajouter une bande
                        </button>
                    </div>
                </div>
            </div>

            @if(session()->has('error'))
                <div class="p-4 rounded-lg text-sm font-medium" style="font-family: 'Manrope', sans-serif; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ session('error') }}
                </div>
            @endif

            <button wire:click="saveAndReturn" class="w-full py-3.5 rounded-xl font-medium text-sm text-white transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'" onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                💾 Sauvegarder et retour
            </button>
        </div>

        <!-- ==================== RIGHT: PREVIEW ==================== -->
        <div class="w-[42%]">
            <div class="sticky top-6">
                <p class="text-xs text-center mb-3 font-medium uppercase tracking-wider"
                   style="font-family: 'Manrope', sans-serif; color: #9CA3AF; letter-spacing: 0.08em;">
                    Aperçu en direct
                </p>
                <div class="rounded-2xl overflow-hidden" style="box-shadow: 0 8px 32px rgba(0,0,0,0.12); border: 1px solid #E5E7EB;">
                    <div class="overflow-y-auto" style="max-height: calc(100vh - 120px); background: #F7F8F4;">

                        <!-- HEADER -->
                        <div style="background: linear-gradient(135deg, {{ $primary_color }} 0%, {{ $primary_color }}dd 100%);">
                            <div class="px-6 pt-10 pb-6 text-center" style="color: {{ $headerTextColor }};">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-xl mx-auto mb-4">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-white/30 border-4 border-white shadow-xl mx-auto mb-4 flex items-center justify-center">
                                        <span class="text-4xl">👤</span>
                                    </div>
                                @endif
                                <h2 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; letter-spacing: -0.02em;">
                                    {{ $full_name ?: 'Votre nom' }}
                                </h2>
                                @if($job_title)
                                    <p class="text-base font-medium mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.9;">{{ $job_title }}</p>
                                @endif
                                @if($company)
                                    <p class="text-sm mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.8;">{{ $company }}</p>
                                @endif
                                @if($location)
                                    <p class="text-xs mt-2" style="font-family: 'Manrope', sans-serif; opacity: 0.75;">📍 {{ $location }}</p>
                                @endif

                                <div class="mt-4 space-y-1.5">
                                    @if($phone)
                                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; opacity: 0.9;">{{ $phone }}</p>
                                    @endif
                                    @if($email)
                                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; opacity: 0.9;">{{ $email }}</p>
                                    @endif
                                    @if($website)
                                        <p class="text-sm truncate px-4" style="font-family: 'Manrope', sans-serif; opacity: 0.9;">{{ $website }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="bg-white">
                            <div class="px-5 py-6 space-y-3">
                                @foreach($contentBands as $band)

                                    @if($band['type'] === 'contact_button')
                                        <div class="block w-full py-3.5 px-5 text-white text-center rounded-xl font-semibold text-sm shadow-md"
                                             style="font-family: 'Manrope', sans-serif; background: {{ $primary_color }};">
                                            <i class="fas fa-address-book mr-2"></i>Ajouter aux contacts
                                        </div>

                                    @elseif($band['type'] === 'social_link')
                                        @php $p = $band['data']['platform'] ?? ''; @endphp
                                        <div class="p-3.5 rounded-xl transition" style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xl">
                                                    @if($p === 'Facebook') <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                                    @elseif($p === 'Instagram') <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                                    @elseif($p === 'LinkedIn') <i class="fab fa-linkedin" style="color: #0A66C2;"></i>
                                                    @elseif($p === 'Twitter') <i class="fab fa-x-twitter" style="color: #000;"></i>
                                                    @elseif($p === 'TikTok') <i class="fab fa-tiktok" style="color: #000;"></i>
                                                    @elseif($p === 'YouTube') <i class="fab fa-youtube" style="color: #FF0000;"></i>
                                                    @elseif($p === 'GitHub') <i class="fab fa-github" style="color: #181717;"></i>
                                                    @else <i class="fas fa-link" style="color: #6B7280;"></i>
                                                    @endif
                                                </div>
                                                <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $p ?: 'Lien' }}</span>
                                            </div>
                                        </div>

                                    @elseif($band['type'] === 'image')
                                        <div class="rounded-xl overflow-hidden shadow-sm">
                                            <img src="{{ Storage::url($band['data']['path']) }}" class="w-full h-auto object-contain max-h-48">
                                        </div>

                                    @elseif($band['type'] === 'text_block')
                                        <div class="p-4 rounded-xl" style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                                            <p class="whitespace-pre-line text-sm leading-relaxed" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $band['data']['text'] ?? '' }}</p>
                                        </div>
                                    @endif

                                @endforeach

                                @if(count($contentBands) === 0)
                                    <div class="py-8 text-center">
                                        <p class="text-sm" style="color: #D1D5DB;">Votre contenu apparaîtra ici</p>
                                    </div>
                                @endif
                            </div>

                            <div class="px-5 pb-6 pt-3 text-center" style="border-top: 1px solid #E5E7EB;">
                                <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                    Propulsé par <span class="font-semibold" style="color: #6B7280;">Link-Card</span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ==================== MODAL ==================== -->
    @if($showAddBandModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 p-4"
             style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
             wire:click.self="closeAddBandModal">
            <div class="bg-white rounded-2xl max-w-md w-full p-6" style="box-shadow: 0 20px 48px rgba(0,0,0,0.2);">

                @if(!$newBandType)
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Ajouter une bande</h3>
                        <p class="text-sm mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Choisissez le type de contenu</p>
                    </div>
                    <div class="space-y-3">
                        @if($availableTypes['social_link']['available'])
                            <button wire:click="selectBandType('social_link')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
                                <div class="flex items-center space-x-4">
                                    <span class="text-3xl"><i class="fas fa-link" style="color: #42B574;"></i></span>
                                    <div>
                                        <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Lien social</p>
                                        <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['social_link']['remaining'] }} restant(s)</p>
                                    </div>
                                </div>
                            </button>
                        @endif
                        @if($availableTypes['image']['available'])
                            <button wire:click="selectBandType('image')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
                                <div class="flex items-center space-x-4">
                                    <span class="text-3xl"><i class="fas fa-image" style="color: #42B574;"></i></span>
                                    <div>
                                        <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Image</p>
                                        <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['image']['remaining'] }} restante(s)</p>
                                    </div>
                                </div>
                            </button>
                        @endif
                        @if($availableTypes['text_block']['available'])
                            <button wire:click="selectBandType('text_block')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-1px)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'; this.style.transform='translateY(0)'">
                                <div class="flex items-center space-x-4">
                                    <span class="text-3xl"><i class="fas fa-align-left" style="color: #42B574;"></i></span>
                                    <div>
                                        <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Texte</p>
                                        <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['text_block']['remaining'] }} restant(s)</p>
                                    </div>
                                </div>
                            </button>
                        @endif
                        @if(!$availableTypes['social_link']['available'] && !$availableTypes['image']['available'] && !$availableTypes['text_block']['available'])
                            <div class="text-center py-4">
                                <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Toutes les limites de votre plan sont atteintes.</p>
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #42B574;">Passez au plan supérieur →</p>
                            </div>
                        @endif
                    </div>
                    <button wire:click="closeAddBandModal" class="w-full mt-4 py-2.5 rounded-lg text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" onmouseover="this.style.color='#4B5563'; this.style.background='#F3F4F6'" onmouseout="this.style.color='#9CA3AF'; this.style.background='transparent'">
                        Annuler
                    </button>

                @else
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center space-x-2">
                            @if(!$editingBandId)
                                <button wire:click="$set('newBandType', '')" class="p-1.5 rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'; this.style.color='#4B5563'" onmouseout="this.style.background='transparent'; this.style.color='#9CA3AF'">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                            @endif
                            <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                                @if($editingBandId) Modifier
                                @else
                                    @if($newBandType === 'social_link') Lien social
                                    @elseif($newBandType === 'image') Image
                                    @elseif($newBandType === 'text_block') Texte
                                    @endif
                                @endif
                            </h3>
                        </div>
                        <button wire:click="closeAddBandModal" class="text-2xl leading-none transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'" onmouseout="this.style.color='#9CA3AF'">✕</button>
                    </div>

                    @if($newBandType === 'social_link')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Plateforme</label>
                                <select wire:model="newSocialPlatform" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
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
                                @error('newSocialPlatform') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">URL</label>
                                <input type="url" wire:model="newSocialUrl" placeholder="https://..." class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                                @error('newSocialUrl') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                            </div>
                            <button wire:click="addSocialLink" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                                {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                            </button>
                        </div>
                    @endif

                    @if($newBandType === 'image')
                        <div class="space-y-4">
                            @if($editingBandId && $currentImagePath)
                                <div>
                                    <p class="text-xs mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Image actuelle :</p>
                                    <img src="{{ Storage::url($currentImagePath) }}" class="w-full h-32 object-cover rounded-lg" style="border: 1px solid #E5E7EB;">
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $editingBandId ? 'Nouvelle image (optionnel)' : 'Image' }}</label>
                                <input type="file" wire:model="newImage" accept="image/*" class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                                <div wire:loading wire:target="newImage" class="flex items-center space-x-1 mt-1">
                                    <svg class="animate-spin h-3 w-3" style="color: #42B574;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    <span class="text-xs" style="color: #9CA3AF;">Upload en cours...</span>
                                </div>
                                @error('newImage') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                            </div>
                            @if($availableTypes['image_url_allowed'])
                                <div>
                                    <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Lien (optionnel)</label>
                                    <input type="url" wire:model="newImageLink" placeholder="https://..." class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'">
                                </div>
                            @else
                                <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">💡 Liens sur images disponibles avec Pro/Premium</p>
                            @endif
                            <button wire:click="addImage" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                                {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                            </button>
                        </div>
                    @endif

                    @if($newBandType === 'text_block')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Texte</label>
                                <div x-data="{ charCount: 0 }">
                                    <textarea wire:model="newTextContent" @input="charCount = $el.value.length" x-init="charCount = $el.value.length" rows="5" maxlength="500" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px; resize: vertical;" onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'" onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"></textarea>
                                    <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;"><span x-text="charCount"></span>/500 caractères</p>
                                </div>
                                @error('newTextContent') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                            </div>
                            <button wire:click="addTextBlock" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                                {{ $editingBandId ? 'Modifier' : 'Ajouter' }}
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endif

    <!-- ==================== SORTABLEJS ==================== -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            function initSortable() {
                const el = document.getElementById('bands-list');
                if (!el) return;
                if (el._sortableInstance) el._sortableInstance.destroy();
                el._sortableInstance = Sortable.create(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'opacity-40',
                    onEnd: function () {
                        const items = el.querySelectorAll('[data-band-id]');
                        const orderedIds = Array.from(items).map(item => parseInt(item.dataset.bandId));
                        const wireEl = el.closest('[wire\\:id]');
                        if (wireEl) {
                            Livewire.find(wireEl.getAttribute('wire:id')).call('reorderBands', orderedIds);
                        }
                    }
                });
            }
            initSortable();
            Livewire.hook('morph.updated', () => requestAnimationFrame(initSortable));
        });
    </script>
</div>
