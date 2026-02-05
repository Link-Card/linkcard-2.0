<div class="bg-white rounded-xl overflow-hidden"
     style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div class="px-5 py-4" style="border-bottom: 1px solid #E5E7EB;">
        <h3 class="font-medium text-sm flex items-center space-x-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
            <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
            <span>Contenu du profil</span>
        </h3>
    </div>
    <div class="p-4">
        <div id="bands-list" class="space-y-2 min-h-[20px]">
            @forelse($contentBands as $index => $band)
                <div data-band-id="{{ $band['id'] }}"
                     class="flex items-center p-3 rounded-lg transition-all duration-150 group"
                     style="background: #F3F4F6; border: 1px solid #E5E7EB;">

                    <div class="drag-handle flex-1 flex items-center cursor-grab active:cursor-grabbing">
                        <span class="mr-3 text-base select-none" style="color: #9CA3AF;">≡</span>
                        <span class="mr-3 w-6 text-center flex items-center justify-center">
                            @if($band['type'] === 'contact_button')
                                <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                            @elseif($band['type'] === 'social_link')
                                <x-social-icon :platform="$band['data']['platform'] ?? ''" />
                            @elseif($band['type'] === 'image')
                                <svg class="w-5 h-5" fill="#D97706" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            @elseif($band['type'] === 'text_block')
                                <svg class="w-5 h-5" fill="#6B7280" viewBox="0 0 24 24"><path d="M3 18h12v-2H3v2zM3 6v2h18V6H3zm0 7h18v-2H3v2z"/></svg>
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

                    <div class="flex items-center space-x-1 opacity-50 group-hover:opacity-100 transition-opacity ml-2">
                        @if($band['type'] !== 'contact_button')
                            <button wire:click="editBand({{ $band['id'] }})" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'" title="Modifier">
                                <svg class="w-4 h-4" fill="#3B82F6" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            </button>
                        @endif
                        <button wire:click="confirmDelete({{ $band['id'] }})" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer">
                            <svg class="w-4 h-4" fill="#EF4444" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
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
            <button wire:click="openAddBandModal" class="w-full py-3 border-2 border-dashed rounded-lg font-medium text-sm text-center transition-all duration-200 flex items-center justify-center space-x-2" style="font-family: 'Manrope', sans-serif; border-color: #D1D5DB; color: #4B5563;" onmouseover="this.style.borderColor='#42B574'; this.style.color='#42B574'" onmouseout="this.style.borderColor='#D1D5DB'; this.style.color='#4B5563'">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                <span>Ajouter une bande</span>
            </button>
        </div>
    </div>
</div>
