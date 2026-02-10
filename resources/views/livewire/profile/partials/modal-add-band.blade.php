@if($showAddBandModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 p-4"
         style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
         wire:click.self="closeAddBandModal">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 max-h-[90vh] overflow-y-auto" style="box-shadow: 0 20px 48px rgba(0,0,0,0.2);">

            @if(!$newBandType)
                <!-- SÉLECTION TYPE -->
                <div class="mb-5">
                    <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Ajouter une bande</h3>
                    <p class="text-sm mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Choisissez le type de contenu</p>
                </div>
                <div class="space-y-3">
                    <!-- Contact Button -->
                    @if($availableTypes['contact_button']['available'])
                        <button wire:click="addContactButton" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                                    <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Bouton Contact</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Télécharger la vCard</p>
                                </div>
                            </div>
                        </button>
                    @endif

                    <!-- Social Link -->
                    @if($availableTypes['social_link']['available'])
                        <button wire:click="selectBandType('social_link')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #EFF6FF;">
                                    <svg class="w-5 h-5" fill="#3B82F6" viewBox="0 0 24 24"><path d="M10.59 13.41c.41.39.41 1.03 0 1.42-.39.39-1.03.39-1.42 0a5.003 5.003 0 010-7.07l3.54-3.54a5.003 5.003 0 017.07 0 5.003 5.003 0 010 7.07l-1.49 1.49c.01-.82-.12-1.64-.4-2.42l.47-.48a2.982 2.982 0 000-4.24 2.982 2.982 0 00-4.24 0l-3.53 3.53a2.982 2.982 0 000 4.24zm2.82-4.24c.39-.39 1.03-.39 1.42 0a5.003 5.003 0 010 7.07l-3.54 3.54a5.003 5.003 0 01-7.07 0 5.003 5.003 0 010-7.07l1.49-1.49c-.01.82.12 1.64.4 2.43l-.47.47a2.982 2.982 0 000 4.24 2.982 2.982 0 004.24 0l3.53-3.53a2.982 2.982 0 000-4.24.973.973 0 010-1.42z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Réseau social</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['social_link']['remaining'] }} restant(s)</p>
                                </div>
                            </div>
                        </button>
                    @endif

                    <!-- Image -->
                    @if($availableTypes['image']['available'])
                        <button wire:click="selectBandType('image')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #FEF3C7;">
                                    <svg class="w-5 h-5" fill="#D97706" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Image(s)</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['image']['remaining'] }} restante(s) · max 2 par bande</p>
                                </div>
                            </div>
                        </button>
                    @endif

                    <!-- Text Block -->
                    @if($availableTypes['text_block']['available'])
                        <button wire:click="selectBandType('text_block')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F3F4F6;">
                                    <svg class="w-5 h-5" fill="#6B7280" viewBox="0 0 24 24"><path d="M3 18h12v-2H3v2zM3 6v2h18V6H3zm0 7h18v-2H3v2z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Bloc de texte</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $availableTypes['text_block']['remaining'] }} restant(s)</p>
                                </div>
                            </div>
                        </button>
                    @endif

                    @if(!$availableTypes['contact_button']['available'] && !$availableTypes['social_link']['available'] && !$availableTypes['image']['available'] && !$availableTypes['text_block']['available'])
                        <div class="text-center py-4">
                            <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Toutes les limites atteintes.</p>
                            <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #42B574;">Passez au plan supérieur →</p>
                        </div>
                    @endif

                    {{-- Séparateur types spécialisés --}}
                    @if($availableTypes['video_embed']['available'] || $availableTypes['image_carousel']['available'] || $availableTypes['cta_button']['available'])
                        <div class="flex items-center gap-3 pt-2">
                            <div class="flex-1 h-px" style="background: #E5E7EB;"></div>
                            <span class="text-[10px] font-semibold uppercase tracking-wider" style="color: #9CA3AF; font-family: 'Manrope', sans-serif;">Spécialisés</span>
                            <div class="flex-1 h-px" style="background: #E5E7EB;"></div>
                        </div>
                    @endif

                    <!-- Video Embed -->
                    @if($availableTypes['video_embed']['available'])
                        <button wire:click="selectBandType('video_embed')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #FEE2E2;">
                                    <svg class="w-5 h-5" fill="#DC2626" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Vidéo</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">YouTube, Vimeo, TikTok · {{ $availableTypes['video_embed']['remaining'] }} restante(s)</p>
                                </div>
                            </div>
                        </button>
                    @elseif(($availableTypes['video_embed']['plan_required'] ?? null))
                        <div class="w-full p-4 rounded-xl opacity-60" style="border: 1.5px solid #E5E7EB; background: #F9FAFB;">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F3F4F6;">
                                    <svg class="w-5 h-5" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                                <div class="flex-1">
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Vidéo</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #F59E0B;">Disponible avec PRO ou PREMIUM</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Image Carousel -->
                    @if($availableTypes['image_carousel']['available'])
                        <button wire:click="selectBandType('image_carousel')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #FEF3C7;">
                                    <svg class="w-5 h-5" fill="#D97706" viewBox="0 0 24 24"><path d="M2 6h4v11H2zm5-1h4v13H7zm5-1h4v15h-4zm5-1h4v17h-4z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Carrousel</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">2-12 images défilantes · {{ $availableTypes['image_carousel']['remaining'] }} restant(s)</p>
                                </div>
                            </div>
                        </button>
                    @elseif(($availableTypes['image_carousel']['plan_required'] ?? null))
                        <div class="w-full p-4 rounded-xl opacity-60" style="border: 1.5px solid #E5E7EB; background: #F9FAFB;">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F3F4F6;">
                                    <svg class="w-5 h-5" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M2 6h4v11H2zm5-1h4v13H7zm5-1h4v15h-4zm5-1h4v17h-4z"/></svg>
                                </span>
                                <div class="flex-1">
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Carrousel</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #F59E0B;">Disponible avec PRO ou PREMIUM</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- CTA Button -->
                    @if($availableTypes['cta_button']['available'])
                        <button wire:click="selectBandType('cta_button')" class="w-full p-4 rounded-xl text-left transition-all duration-200" style="border: 1.5px solid #E5E7EB;" onmouseover="this.style.borderColor='#42B574'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                                    <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z"/></svg>
                                </span>
                                <div>
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Bouton</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Lien externe personnalisé · {{ $availableTypes['cta_button']['remaining'] }} restant(s)</p>
                                </div>
                            </div>
                        </button>
                    @elseif(($availableTypes['cta_button']['plan_required'] ?? null))
                        <div class="w-full p-4 rounded-xl opacity-60" style="border: 1.5px solid #E5E7EB; background: #F9FAFB;">
                            <div class="flex items-center space-x-4">
                                <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #F3F4F6;">
                                    <svg class="w-5 h-5" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z"/></svg>
                                </span>
                                <div class="flex-1">
                                    <p class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Bouton</p>
                                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #F59E0B;">Disponible avec PRO ou PREMIUM</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <button wire:click="closeAddBandModal" class="w-full mt-4 py-2.5 rounded-lg text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" onmouseover="this.style.color='#4B5563'; this.style.background='#F3F4F6'" onmouseout="this.style.color='#9CA3AF'; this.style.background='transparent'">
                    Annuler
                </button>

            @else
                <!-- FORMULAIRE SPÉCIFIQUE -->
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center space-x-2">
                        @if(!$editingBandId)
                            <button wire:click="$set('newBandType', '')" class="p-1.5 rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'; this.style.color='#4B5563'" onmouseout="this.style.background='transparent'; this.style.color='#9CA3AF'">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                        @endif
                        <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                            @if($editingBandId) Modifier @else Ajouter @endif
                            @if($newBandType === 'social_link') un lien
                            @elseif($newBandType === 'image') une image
                            @elseif($newBandType === 'text_block') du texte
                            @elseif($newBandType === 'video_embed') une vidéo
                            @elseif($newBandType === 'image_carousel') un carrousel
                            @elseif($newBandType === 'cta_button') un bouton
                            @endif
                        </h3>
                    </div>
                    <button wire:click="closeAddBandModal" class="text-2xl leading-none transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#4B5563'" onmouseout="this.style.color='#9CA3AF'">×</button>
                </div>

                <!-- SOCIAL LINK -->
                @if($newBandType === 'social_link')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Plateforme</label>
                            <select wire:model="newSocialPlatform" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                                <option value="">Sélectionner...</option>
                                <optgroup label="Réseaux sociaux">
                                    <option value="Facebook">Facebook</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                    <option value="Twitter">Twitter / X</option>
                                    <option value="TikTok">TikTok</option>
                                    <option value="Snapchat">Snapchat</option>
                                    <option value="Pinterest">Pinterest</option>
                                </optgroup>
                                <optgroup label="Messagerie">
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Telegram">Telegram</option>
                                    <option value="Discord">Discord</option>
                                </optgroup>
                                <optgroup label="Vidéo & Streaming">
                                    <option value="YouTube">YouTube</option>
                                    <option value="Twitch">Twitch</option>
                                </optgroup>
                                <optgroup label="Musique">
                                    <option value="Spotify">Spotify</option>
                                    <option value="Apple Music">Apple Music</option>
                                    <option value="SoundCloud">SoundCloud</option>
                                </optgroup>
                                <optgroup label="Autre">
                                    <option value="GitHub">GitHub</option>
                                    <option value="Site web">Site web</option>
                                    <option value="Autre">Autre lien</option>
                                </optgroup>
                            </select>
                            @error('newSocialPlatform') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">URL</label>
                            <input type="url" wire:model="newSocialUrl" placeholder="https://..." class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            @error('newSocialUrl') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addSocialLink" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- IMAGE -->
                @if($newBandType === 'image')
                    <div class="space-y-4">
                        @if($editingBandId && !empty($currentImagePaths))
                            <div>
                                <p class="text-xs mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Image(s) actuelle(s) :</p>
                                <div class="flex gap-2">
                                    @foreach($currentImagePaths as $path)
                                        <img src="{{ Storage::url($path) }}" class="h-20 w-auto object-cover rounded-lg" style="border: 1px solid #E5E7EB;">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                                {{ $editingBandId ? 'Remplacer les images' : 'Images (1 ou 2)' }}
                            </label>
                            <div x-data="{ imgProgress: 0, imgUploading: false, imgError: false }"
                                 x-on:livewire-upload-start="imgUploading = true; imgProgress = 0; imgError = false"
                                 x-on:livewire-upload-finish="imgUploading = false; imgProgress = 100"
                                 x-on:livewire-upload-cancel="imgUploading = false; imgProgress = 0"
                                 x-on:livewire-upload-error="imgUploading = false; imgProgress = 0; imgError = true"
                                 x-on:livewire-upload-progress="imgProgress = $event.detail.progress">
                                <input type="file" wire:model="newImages" accept="image/*" multiple class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                    Max 2 images · 50 MB par image · {{ $availableTypes['image']['remaining'] }} restante(s)
                                </p>
                                <div x-show="imgUploading" x-cloak class="mt-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium" style="color: #42B574; font-family: 'Manrope', sans-serif;">Upload en cours...</span>
                                        <span class="text-xs font-medium" style="color: #42B574; font-family: 'Manrope', sans-serif;" x-text="Math.round(imgProgress) + '%'"></span>
                                    </div>
                                    <div class="w-full h-2 rounded-full overflow-hidden" style="background: #E5E7EB;">
                                        <div class="h-full rounded-full transition-all duration-300" :style="'background: #42B574; width: ' + imgProgress + '%'"></div>
                                    </div>
                                </div>
                                <div x-show="imgError" x-cloak class="mt-2 p-2 rounded-lg text-xs" style="background: #FEF2F2; color: #EF4444; font-family: 'Manrope', sans-serif;">
                                    Échec de l'upload. Fichier trop volumineux ou format non supporté.
                                </div>
                            </div>
                            @error('newImages') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                            @error('newImages.*') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        @if($availableTypes['image_url_allowed'])
                            <div>
                                <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Lien au clic (optionnel)</label>
                                <input type="url" wire:model="newImageLink" placeholder="https://..." class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            </div>
                        @else
                            <p class="text-xs flex items-center space-x-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                <svg class="w-4 h-4" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                <span>Liens sur images disponibles avec Pro/Premium</span>
                            </p>
                        @endif
                        <button wire:click="addImage" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- TEXT BLOCK -->
                @if($newBandType === 'text_block')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Texte</label>
                            <div x-data="{ charCount: 0 }">
                                <textarea wire:model="newTextContent" @input="charCount = $el.value.length" x-init="charCount = $el.value.length" rows="5" maxlength="500" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px; resize: vertical;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'" placeholder="Écrivez votre texte ici..."></textarea>
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;"><span x-text="charCount"></span>/500 caractères</p>
                            </div>
                            @error('newTextContent') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addTextBlock" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- VIDEO EMBED -->
                @if($newBandType === 'video_embed')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">URL de la vidéo</label>
                            <input type="url" wire:model="newVideoUrl" placeholder="https://youtube.com/watch?v=..." class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            <p class="text-xs mt-1.5" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">YouTube, Vimeo ou TikTok supportés</p>
                            @error('newVideoUrl') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="addVideoEmbed" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}
                        </button>
                    </div>
                @endif

                <!-- IMAGE CAROUSEL -->
                @if($newBandType === 'image_carousel')
                    <div class="space-y-4" x-data="{ carouselProgress: 0, carouselUploading: false, carouselError: false }"
                         x-on:livewire-upload-start="carouselUploading = true; carouselProgress = 0; carouselError = false"
                         x-on:livewire-upload-finish="carouselUploading = false; carouselProgress = 100"
                         x-on:livewire-upload-cancel="carouselUploading = false; carouselProgress = 0"
                         x-on:livewire-upload-error="carouselUploading = false; carouselProgress = 0; carouselError = true"
                         x-on:livewire-upload-progress="carouselProgress = $event.detail.progress">
                        @if($editingBandId && !empty($existingCarouselImages))
                            <div>
                                <p class="text-xs mb-2 font-medium" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Images actuelles ({{ count($existingCarouselImages) }}) :</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($existingCarouselImages as $idx => $img)
                                        <div class="relative group">
                                            <img src="{{ Storage::url($img['path']) }}" class="h-16 w-16 object-cover rounded-lg" style="border: 1px solid #E5E7EB;">
                                            <button wire:click="removeCarouselImage({{ $idx }})" class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" style="background: #EF4444;">
                                                <svg class="w-3 h-3" fill="white" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                                {{ $editingBandId ? 'Ajouter des images' : 'Images (2-12)' }}
                            </label>
                            <div>
                                <input type="file" wire:model="newCarouselImages" accept="image/jpeg,image/png,image/gif,image/webp" multiple class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                                <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">Min 2, max 12 images · JPG, PNG, WebP · 20 MB max chacune</p>
                                <div x-show="carouselError" x-cloak class="mt-2 p-2 rounded-lg text-xs" style="background: #FEF2F2; color: #EF4444; font-family: 'Manrope', sans-serif;">
                                    ⚠️ Échec de l'upload. Essayez avec moins d'images ou des fichiers plus petits.
                                </div>
                                <div x-show="carouselUploading" x-cloak class="mt-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium" style="color: #42B574; font-family: 'Manrope', sans-serif;">Upload en cours...</span>
                                        <span class="text-xs font-medium" style="color: #42B574; font-family: 'Manrope', sans-serif;" x-text="Math.round(carouselProgress) + '%'"></span>
                                    </div>
                                    <div class="w-full h-2 rounded-full overflow-hidden" style="background: #E5E7EB;">
                                        <div class="h-full rounded-full transition-all duration-300" :style="'background: #42B574; width: ' + carouselProgress + '%'"></div>
                                    </div>
                                </div>
                                <div x-show="!carouselUploading && carouselProgress === 100" x-cloak class="mt-2 p-2 rounded-lg text-xs flex items-center space-x-1" style="background: #F0F9F4; color: #42B574; font-family: 'Manrope', sans-serif;">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="#42B574" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                    <span>Images prêtes — cliquez Ajouter</span>
                                </div>
                            </div>
                            @error('newCarouselImages') <span class="text-xs mt-1 block" style="color: #EF4444; font-family: 'Manrope', sans-serif;">{{ $message }}</span> @enderror
                            @error('newCarouselImages.*') <span class="text-xs mt-1 block" style="color: #EF4444; font-family: 'Manrope', sans-serif;">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center space-x-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="newCarouselAutoplay" class="sr-only peer">
                                <div class="w-9 h-5 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all" style="background: #D1D5DB;" x-bind:style="$wire.newCarouselAutoplay ? 'background: #42B574' : 'background: #D1D5DB'"></div>
                            </label>
                            <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Défilement automatique</span>
                        </div>
                        <button wire:click="addImageCarousel" wire:loading.attr="disabled"
                            x-bind:disabled="carouselUploading"
                            class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="if(!this.disabled)this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            <span wire:loading.remove wire:target="addImageCarousel">
                                <template x-if="carouselUploading">
                                    <span>⏳ Upload en cours...</span>
                                </template>
                                <template x-if="!carouselUploading">
                                    <span>{{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}</span>
                                </template>
                            </span>
                            <span wire:loading wire:target="addImageCarousel">Enregistrement...</span>
                        </button>
                    </div>
                @endif

                <!-- CTA BUTTON -->
                @if($newBandType === 'cta_button')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Texte du bouton</label>
                            <input type="text" wire:model="newCtaLabel" maxlength="60" placeholder="Réserver une consultation" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            @error('newCtaLabel') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">URL de destination</label>
                            <input type="text" wire:model="newCtaUrl" placeholder="calendly.com/mon-lien" class="w-full px-4 py-2.5 rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; font-size: 14px;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">https:// sera ajouté automatiquement</p>
                            @error('newCtaUrl') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Couleur du bouton</label>
                            <div class="flex items-center gap-3">
                                <input type="color" wire:model.live="newCtaBgColor" class="w-10 h-10 rounded-lg cursor-pointer border-0 p-0" style="background: transparent;">
                                <input type="text" wire:model.live="newCtaBgColor" class="flex-1 px-3 py-2 rounded-lg text-sm font-mono" style="border: 1.5px solid #D1D5DB;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#D1D5DB'">
                            </div>
                            {{-- Preview --}}
                            <div class="mt-2 p-3 rounded-lg text-center text-sm font-medium transition-all" style="background: {{ $newCtaBgColor ?? '#42B574' }}; color: {{ (function() { $hex = ltrim($newCtaBgColor ?? '#42B574', '#'); if (strlen($hex) !== 6) return '#FFFFFF'; $r = hexdec(substr($hex, 0, 2)); $g = hexdec(substr($hex, 2, 2)); $b = hexdec(substr($hex, 4, 2)); return ((0.299 * $r + 0.587 * $g + 0.114 * $b) / 255 > 0.6) ? '#2C2A27' : '#FFFFFF'; })() }}; border-radius: 12px; font-family: 'Manrope', sans-serif;">
                                {{ $newCtaIcon ? $newCtaIcon . ' ' : '' }}{{ $newCtaLabel ?: 'Aperçu du bouton' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Icône (optionnel)</label>
                            <div class="flex gap-2 flex-wrap">
                                <button wire:click="$set('newCtaIcon', '')" class="w-10 h-10 rounded-lg text-xs flex items-center justify-center transition-all" style="border: 1.5px solid {{ $newCtaIcon === '' ? '#42B574' : '#E5E7EB' }}; background: {{ $newCtaIcon === '' ? '#F0F9F4' : 'white' }}; font-family: 'Manrope', sans-serif; color: #9CA3AF;">Ø</button>
                                @foreach(['📅', '🛒', '📞', '📧', '💬', '🎯', '📍', '🎟️', '📝', '🔗'] as $emoji)
                                    <button wire:click="$set('newCtaIcon', '{{ $emoji }}')" class="w-10 h-10 rounded-lg text-lg flex items-center justify-center transition-all" style="border: 1.5px solid {{ $newCtaIcon === $emoji ? '#42B574' : '#E5E7EB' }}; background: {{ $newCtaIcon === $emoji ? '#F0F9F4' : 'white' }};">{{ $emoji }}</button>
                                @endforeach
                            </div>
                        </div>
                        <button wire:click="addCtaButton" class="w-full py-2.5 text-white rounded-lg font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            {{ $editingBandId ? 'Enregistrer' : 'Ajouter' }}
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endif
