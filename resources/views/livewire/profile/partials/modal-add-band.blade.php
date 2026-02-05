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
                            <input type="file" wire:model="newImages" accept="image/*" multiple class="w-full text-sm rounded-lg" style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; padding: 8px 12px;">
                            <p class="text-xs mt-1" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                Max 2 images · 50 MB par image · {{ $availableTypes['image']['remaining'] }} restante(s)
                            </p>
                            <div wire:loading wire:target="newImages" class="flex items-center space-x-1 mt-1">
                                <svg class="animate-spin h-3 w-3" style="color: #42B574;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                <span class="text-xs" style="color: #9CA3AF;">Upload...</span>
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
            @endif
        </div>
    </div>
@endif
