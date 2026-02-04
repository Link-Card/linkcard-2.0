<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="bg-white rounded-xl overflow-hidden"
     style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div class="px-5 py-4" style="border-bottom: 1px solid #E5E7EB;">
        <h3 class="font-medium text-sm flex items-center space-x-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
            <i class="fas fa-layer-group" style="color: #42B574;"></i>
            <span>Contenu du profil</span>
        </h3>
    </div>
    <div class="p-4">
        <div id="bands-list" class="space-y-2 min-h-[20px]">
            @forelse($contentBands as $index => $band)
                <div data-band-id="{{ $band['id'] }}"
                     class="flex items-center p-3 rounded-lg transition-all duration-150 group"
                     style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                    
                    <!-- DRAG ZONE (≡ + icône + texte) -->
                    <div class="drag-handle flex-1 flex items-center cursor-grab active:cursor-grabbing">
                        <span class="mr-3 text-base select-none" style="color: #9CA3AF;">≡</span>
                        <span class="mr-3 w-6 text-center">
                            @if($band['type'] === 'contact_button')
                                <i class="fas fa-address-book text-lg" style="color: #42B574;"></i>
                            @elseif($band['type'] === 'social_link')
                                @php $p = $band['data']['platform'] ?? ''; @endphp
                                @if($p === 'Facebook') <i class="fab fa-facebook text-lg" style="color: #1877F2;"></i>
                                @elseif($p === 'Instagram') <i class="fab fa-instagram text-lg" style="color: #E4405F;"></i>
                                @elseif($p === 'LinkedIn') <i class="fab fa-linkedin text-lg" style="color: #0A66C2;"></i>
                                @elseif($p === 'Twitter') <i class="fab fa-x-twitter text-lg" style="color: #000;"></i>
                                @elseif($p === 'TikTok') <i class="fab fa-tiktok text-lg" style="color: #000;"></i>
                                @elseif($p === 'YouTube') <i class="fab fa-youtube text-lg" style="color: #FF0000;"></i>
                                @elseif($p === 'GitHub') <i class="fab fa-github text-lg" style="color: #181717;"></i>
                                @elseif($p === 'Snapchat') <i class="fab fa-snapchat text-lg" style="color: #FFFC00;"></i>
                                @elseif($p === 'Pinterest') <i class="fab fa-pinterest text-lg" style="color: #E60023;"></i>
                                @elseif($p === 'WhatsApp') <i class="fab fa-whatsapp text-lg" style="color: #25D366;"></i>
                                @elseif($p === 'Telegram') <i class="fab fa-telegram text-lg" style="color: #0088cc;"></i>
                                @elseif($p === 'Discord') <i class="fab fa-discord text-lg" style="color: #5865F2;"></i>
                                @elseif($p === 'Twitch') <i class="fab fa-twitch text-lg" style="color: #9146FF;"></i>
                                @elseif($p === 'Spotify') <i class="fab fa-spotify text-lg" style="color: #1DB954;"></i>
                                @elseif($p === 'Apple Music') <i class="fab fa-apple text-lg" style="color: #000;"></i>
                                @elseif($p === 'SoundCloud') <i class="fab fa-soundcloud text-lg" style="color: #FF5500;"></i>
                                @else <i class="fas fa-link text-lg" style="color: #6B7280;"></i>
                                @endif
                            @elseif($band['type'] === 'image')
                                <i class="fas fa-image text-lg" style="color: #D97706;"></i>
                            @elseif($band['type'] === 'text_block')
                                <i class="fas fa-align-left text-lg" style="color: #6B7280;"></i>
                            @endif
                        </span>
                        <span class="text-sm font-medium truncate" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                            @if($band['type'] === 'contact_button') Ajouter aux contacts
                            @elseif($band['type'] === 'social_link') {{ $band['data']['platform'] ?? 'Lien social' }}
                            @elseif($band['type'] === 'image')
                                @php
                                    $imgCount = isset($band['data']['images']) ? count($band['data']['images']) : (isset($band['data']['path']) ? 1 : 0);
                                @endphp
                                Image{{ $imgCount > 1 ? 's ('.$imgCount.')' : '' }}
                            @elseif($band['type'] === 'text_block') {{ Str::limit($band['data']['text'] ?? 'Texte', 30) }}
                            @endif
                        </span>
                    </div>
                    
                    <!-- BOUTONS (hors drag zone) -->
                    <div class="flex items-center space-x-1 opacity-50 group-hover:opacity-100 transition-opacity ml-2">
                        @if($band['type'] !== 'contact_button')
                            <button wire:click="editBand({{ $band['id'] }})" class="p-1.5 rounded transition-colors" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'" title="Modifier">
                                <i class="fas fa-pen text-xs" style="color: #3B82F6;"></i>
                            </button>
                        @endif
                        <button wire:click="confirmDelete({{ $band['id'] }})" class="p-1.5 rounded transition-colors" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer">
                            <i class="fas fa-trash text-xs" style="color: #EF4444;"></i>
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
                <i class="fas fa-plus mr-1"></i> Ajouter une bande
            </button>
        </div>
    </div>
</div>
