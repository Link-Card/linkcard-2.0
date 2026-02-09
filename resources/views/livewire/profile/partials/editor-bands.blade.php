<div class="bg-white rounded-xl overflow-hidden"
     style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div class="px-5 py-4" style="border-bottom: 1px solid #E5E7EB;">
        <h3 class="font-medium text-sm flex items-center space-x-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
            <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
            <span>Contenu du profil</span>
        </h3>
    </div>
    
    @if($hiddenCount > 0)
        @php
            $planNames = ['pro' => 'PRO', 'premium' => 'PREMIUM'];
            $planName = $planNames[$requiredPlan] ?? 'PRO';
            $currentPlanName = ['free' => 'gratuit', 'pro' => 'PRO', 'premium' => 'PREMIUM'][$userPlan] ?? 'gratuit';
        @endphp
        <div class="mx-4 mt-4 p-3 rounded-lg" style="background: #FEF3C7; border: 1px solid #F59E0B;">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="#D97706" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span class="text-sm font-medium" style="color: #92400E;">{{ $hiddenCount }} élément(s) masqué(s) - limite du forfait {{ $currentPlanName }} atteinte</span>
                </div>
                <a href="{{ route('subscription.plans') }}" class="text-sm font-medium px-3 py-1 rounded-lg transition-colors" style="background: #F59E0B; color: white;" onmouseover="this.style.background='#D97706'" onmouseout="this.style.background='#F59E0B'">
                    Passer à {{ $planName }}
                </a>
            </div>
        </div>
    @endif
    
    <div class="p-4">
        <div id="bands-list" class="space-y-2 min-h-[20px]">
            @forelse($contentBands as $index => $band)
                @php 
                    $isHidden = $band['is_hidden'] ?? false;
                    $planNames = ['pro' => 'PRO', 'premium' => 'PREMIUM'];
                    $upgradePlanName = $planNames[$requiredPlan] ?? 'PRO';
                @endphp
                <div data-band-id="{{ $band['id'] }}"
                     class="flex items-center p-3 rounded-lg transition-all duration-150 group {{ $isHidden ? 'opacity-60' : '' }}"
                     style="background: {{ $isHidden ? '#FEF2F2' : '#F3F4F6' }}; border: 1px solid {{ $isHidden ? '#FCA5A5' : '#E5E7EB' }};">

                    <div class="drag-handle flex-1 flex items-center {{ $isHidden ? '' : 'cursor-grab active:cursor-grabbing' }}">
                        @if(!$isHidden)
                            <span class="mr-3 text-base select-none" style="color: #9CA3AF;">≡</span>
                        @else
                            <span class="mr-3 text-base select-none" style="color: #EF4444;">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                            </span>
                        @endif
                        
                        <span class="mr-3 w-6 text-center flex items-center justify-center">
                            @if($band['type'] === 'contact_button')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#42B574' }}" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                            @elseif($band['type'] === 'social_link')
                                <x-social-icon :platform="$band['data']['platform'] ?? ''" />
                            @elseif($band['type'] === 'image')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#D97706' }}" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            @elseif($band['type'] === 'text_block')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#6B7280' }}" viewBox="0 0 24 24"><path d="M3 18h12v-2H3v2zM3 6v2h18V6H3zm0 7h18v-2H3v2z"/></svg>
                            @elseif($band['type'] === 'video_embed')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#DC2626' }}" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            @elseif($band['type'] === 'image_carousel')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#D97706' }}" viewBox="0 0 24 24"><path d="M2 6h4v11H2zm5-1h4v13H7zm5-1h4v15h-4zm5-1h4v17h-4z"/></svg>
                            @elseif($band['type'] === 'cta_button')
                                <svg class="w-5 h-5" fill="{{ $isHidden ? '#9CA3AF' : '#42B574' }}" viewBox="0 0 24 24"><path d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z"/></svg>
                            @endif
                        </span>
                        
                        <div class="flex-1">
                            <span class="text-sm font-medium truncate block" style="font-family: 'Manrope', sans-serif; color: {{ $isHidden ? '#9CA3AF' : '#2C2A27' }};">
                                @if($band['type'] === 'contact_button') Ajouter aux contacts
                                @elseif($band['type'] === 'social_link') {{ $band['data']['platform'] ?? 'Lien social' }}
                                @elseif($band['type'] === 'image')
                                    @php
                                        $imgCount = isset($band['data']['images']) ? count($band['data']['images']) : (isset($band['data']['path']) ? 1 : 0);
                                    @endphp
                                    Image{{ $imgCount > 1 ? 's ('.$imgCount.')' : '' }}
                                @elseif($band['type'] === 'text_block') {{ Str::limit($band['data']['text'] ?? 'Texte', 30) }}
                                @elseif($band['type'] === 'video_embed') Vidéo {{ ucfirst($band['data']['platform'] ?? '') }}
                                @elseif($band['type'] === 'image_carousel') Carrousel ({{ count($band['data']['images'] ?? []) }} images)
                                @elseif($band['type'] === 'cta_button') {{ $band['data']['icon'] ?? '🔗' }} {{ $band['data']['label'] ?? 'Bouton CTA' }}
                                @endif
                            </span>
                            @if($isHidden)
                                <span class="text-xs" style="color: #EF4444;">Masqué - Passez à {{ $upgradePlanName }} pour débloquer</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-1 opacity-50 group-hover:opacity-100 transition-opacity ml-2">
                        @if($isHidden)
                            <a href="{{ route('subscription.plans') }}" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#F0F9F4'" onmouseout="this.style.background='transparent'" title="Débloquer">
                                <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            </a>
                            <button wire:click="confirmDelete({{ $band['id'] }})" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer définitivement">
                                <svg class="w-4 h-4" fill="#EF4444" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        @else
                            @if($band['type'] !== 'contact_button')
                                <button wire:click="editBand({{ $band['id'] }})" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'" title="Modifier">
                                    <svg class="w-4 h-4" fill="#3B82F6" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                </button>
                            @endif
                            <button wire:click="confirmDelete({{ $band['id'] }})" class="p-1.5 rounded transition-colors" style="background: transparent;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'" title="Supprimer">
                                <svg class="w-4 h-4" fill="#EF4444" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        @endif
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
