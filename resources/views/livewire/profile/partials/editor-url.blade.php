@php
    $user = auth()->user();
    $plan = $user->plan ?? 'free';
    $canChange = $profile->canChangeUsername();
    $isPro = in_array($plan, ['pro', 'premium']);
@endphp

<div class="bg-white rounded-xl overflow-hidden" style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <div class="px-5 py-4">
        <div class="flex items-center space-x-2 mb-2">
            <svg class="w-4 h-4" style="color: #42B574;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            <span class="font-medium text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Lien du profil</span>
        </div>

        @if(!$editingUsername)
            {{-- Mode affichage --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-1 min-w-0">
                    <span class="text-sm shrink-0" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">app.linkcard.ca/</span>
                    <span class="text-sm font-medium truncate" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $profile->username }}</span>
                </div>
                <div class="flex items-center space-x-2 shrink-0 ml-3">
                    {{-- Copier --}}
                    <button onclick="navigator.clipboard.writeText('{{ route('profile.public', $profile->username) }}'); this.innerHTML='✓'; setTimeout(() => this.innerHTML='<svg class=\'w-4 h-4\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\'/></svg>', 1500)"
                            class="p-1.5 rounded-lg transition" style="color: #9CA3AF;"
                            onmouseover="this.style.background='#F0F9F4'; this.style.color='#42B574'"
                            onmouseout="this.style.background='transparent'; this.style.color='#9CA3AF'"
                            title="Copier le lien">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                    </button>

                    {{-- Modifier (PRO/PREMIUM only) --}}
                    @if($isPro)
                        @if($canChange['allowed'])
                            <button wire:click="$set('editingUsername', true)"
                                    class="px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                    style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;"
                                    onmouseover="this.style.background='#42B574'; this.style.color='#fff'"
                                    onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                                Personnaliser
                            </button>
                        @else
                            <span class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" title="{{ $canChange['reason'] }}">
                                🔒 {{ $canChange['reason'] }}
                            </span>
                        @endif
                    @else
                        <a href="{{ route('subscription.plans') }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium transition inline-flex items-center space-x-1"
                           style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;"
                           onmouseover="this.style.background='#42B574'; this.style.color='#fff'"
                           onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                            <span>⭐</span>
                            <span>PRO</span>
                        </a>
                    @endif
                </div>
            </div>
        @else
            {{-- Mode édition --}}
            <div class="space-y-3">
                <div class="flex items-center space-x-1">
                    <span class="text-sm shrink-0" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">app.linkcard.ca/</span>
                    <input type="text" wire:model="customUsername"
                           class="flex-1 px-3 py-2 rounded-lg text-sm"
                           style="font-family: 'Manrope', sans-serif; border: 1.5px solid #42B574; color: #2C2A27; box-shadow: 0 0 0 3px #F0F9F4;"
                           placeholder="votre-nom"
                           maxlength="30"
                           autofocus>
                </div>

                @if($usernameError)
                    <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #EF4444;">{{ $usernameError }}</p>
                @endif

                <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                    3-30 caractères : lettres minuscules, chiffres, tirets.
                    @if($plan === 'pro') Modifiable 1x par année. @else Modifiable 1x par 3 mois. @endif
                </p>

                <div class="flex items-center space-x-2">
                    <button wire:click="updateUsername"
                            class="px-4 py-2 rounded-lg text-xs font-medium text-white transition"
                            style="font-family: 'Manrope', sans-serif; background: #42B574;"
                            onmouseover="this.style.background='#3DA367'"
                            onmouseout="this.style.background='#42B574'">
                        Confirmer
                    </button>
                    <button wire:click="cancelUsernameEdit"
                            class="px-4 py-2 rounded-lg text-xs font-medium transition"
                            style="font-family: 'Manrope', sans-serif; color: #4B5563; border: 1px solid #D1D5DB;">
                        Annuler
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
