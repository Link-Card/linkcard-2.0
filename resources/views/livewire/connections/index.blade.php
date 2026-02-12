<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Mes Connexions</h1>
            <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                <span class="font-medium">{{ $contactsCount }}</span> contact{{ $contactsCount > 1 ? 's' : '' }}
            </p>
        </div>

        @if(session()->has('message'))
            <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                {{ session('message') }}
            </div>
        @endif

        <!-- DEMANDES REÇUES -->
        @if($pendingReceived->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-base font-semibold mb-3 flex items-center gap-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #EF4444;">{{ $pendingReceived->count() }}</span>
                    Demandes reçues
                </h2>
                <div class="space-y-3">
                    @foreach($pendingReceived as $connection)
                        @php $user = $connection->sender; $profile = $user->profiles->first(); @endphp
                        <div class="bg-white rounded-xl border p-4 flex flex-col sm:flex-row sm:items-center gap-3" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                @if($profile && $profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-12 h-12 rounded-full object-cover flex-shrink-0" alt="">
                                @else
                                    <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center" style="background: #F0F9F4;">
                                        <span class="text-xl">👤</span>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-sm truncate" style="color: #2C2A27;">{{ $profile->full_name ?? $user->name }}</p>
                                    @if($profile)
                                        <p class="text-xs truncate" style="color: #4B5563;">
                                            {{ $profile->job_title }}{{ $profile->company ? ' @ '.$profile->company : '' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <button wire:click="acceptRequest({{ $connection->id }})"
                                    class="px-4 py-2 text-xs font-medium text-white rounded-lg transition-all"
                                    style="background: #42B574;"
                                    onmouseover="this.style.background='#3DA367'"
                                    onmouseout="this.style.background='#42B574'">
                                    Accepter
                                </button>
                                <button wire:click="declineRequest({{ $connection->id }})"
                                    class="px-4 py-2 text-xs font-medium rounded-lg transition-all"
                                    style="background: #F3F4F6; color: #4B5563;"
                                    onmouseover="this.style.background='#E5E7EB'"
                                    onmouseout="this.style.background='#F3F4F6'">
                                    Refuser
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- DEMANDES ENVOYÉES -->
        @if($pendingSent->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-base font-semibold mb-3" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    Demandes envoyées
                </h2>
                <div class="space-y-3">
                    @foreach($pendingSent as $connection)
                        @php $user = $connection->receiver; $profile = $user->profiles->first(); @endphp
                        <div class="bg-white rounded-xl border p-4 flex flex-col sm:flex-row sm:items-center gap-3" style="border-color: #F59E0B; border-style: dashed; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                @if($profile && $profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-12 h-12 rounded-full object-cover flex-shrink-0" alt="">
                                @else
                                    <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center" style="background: #FEF3C7;">
                                        <span class="text-xl">👤</span>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-sm truncate" style="color: #2C2A27;">{{ $profile->full_name ?? $user->name }}</p>
                                    @if($profile)
                                        <p class="text-xs truncate" style="color: #4B5563;">
                                            {{ $profile->job_title }}{{ $profile->company ? ' @ '.$profile->company : '' }}
                                        </p>
                                    @endif
                                    <p class="text-xs mt-0.5" style="color: #F59E0B;">⏳ En attente</p>
                                </div>
                            </div>
                            <button wire:click="cancelRequest({{ $connection->id }})"
                                class="px-4 py-2 text-xs font-medium rounded-lg transition-all flex-shrink-0"
                                style="background: #FEF3C7; color: #92400E;"
                                onmouseover="this.style.background='#FDE68A'"
                                onmouseout="this.style.background='#FEF3C7'">
                                Annuler
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- MES CONTACTS -->
        <div class="mb-8">
            <h2 class="text-base font-semibold mb-3" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                Mes contacts
            </h2>

            @if($contacts->isEmpty())
                <div class="bg-white rounded-xl border p-10 text-center" style="border-color: #E5E7EB;">
                    <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background: #F0F9F4;">
                        <svg class="w-8 h-8" fill="#42B574" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Aucun contact</h3>
                    <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Scannez un profil Link-Card pour vous connecter</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($contacts as $connection)
                        @php
                            $otherUser = $connection->getOtherUser(auth()->id());
                            $profile = $otherUser?->profiles->first();
                        @endphp
                        @if($otherUser)
                            <div class="bg-white rounded-xl border p-4 transition-all duration-200" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                <div class="flex items-center gap-3 mb-3">
                                    @if($profile && $profile->photo_path)
                                        <img src="{{ Storage::url($profile->photo_path) }}" class="w-14 h-14 rounded-full object-cover flex-shrink-0" alt="">
                                    @else
                                        <div class="w-14 h-14 rounded-full flex-shrink-0 flex items-center justify-center" style="background: #F0F9F4;">
                                            <span class="text-2xl">👤</span>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-sm truncate" style="color: #2C2A27;">{{ $profile->full_name ?? $otherUser->name }}</p>
                                        @if($profile)
                                            @if($profile->job_title)
                                                <p class="text-xs truncate" style="color: #4B5563;">{{ $profile->job_title }}</p>
                                            @endif
                                            @if($profile->company)
                                                <p class="text-xs truncate" style="color: #9CA3AF;">{{ $profile->company }}</p>
                                            @endif
                                        @endif
                                    </div>
                                    {{-- Quick contact icons --}}
                                    <div class="flex gap-1.5 flex-shrink-0">
                                        @if($profile && $profile->phone)
                                            <a href="tel:{{ $profile->phone }}" title="Appeler {{ $profile->full_name ?? $otherUser->name }}"
                                               class="w-9 h-9 rounded-full flex items-center justify-center transition-all"
                                               style="background: #F0F9F4;"
                                               onmouseover="this.style.background='#42B574'; this.querySelector('svg').style.fill='#FFFFFF'"
                                               onmouseout="this.style.background='#F0F9F4'; this.querySelector('svg').style.fill='#42B574'">
                                                <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                                            </a>
                                        @endif
                                        @if($profile && $profile->email)
                                            <a href="mailto:{{ $profile->email }}" title="Envoyer un courriel à {{ $profile->full_name ?? $otherUser->name }}"
                                               class="w-9 h-9 rounded-full flex items-center justify-center transition-all"
                                               style="background: #EFF6FF;"
                                               onmouseover="this.style.background='#4A7FBF'; this.querySelector('svg').style.fill='#FFFFFF'"
                                               onmouseout="this.style.background='#EFF6FF'; this.querySelector('svg').style.fill='#4A7FBF'">
                                                <svg class="w-4 h-4" fill="#4A7FBF" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    @if($profile)
                                        <a href="{{ route('profile.public', $profile->username) }}"
                                           class="flex-1 text-center px-3 py-2 text-xs font-medium text-white rounded-lg transition-all"
                                           style="background: #42B574;"
                                           onmouseover="this.style.background='#3DA367'"
                                           onmouseout="this.style.background='#42B574'">
                                            Voir profil
                                        </a>
                                    @endif
                                    @if($confirmRemoveId === $connection->id)
                                        <button wire:click="removeConnection"
                                            class="flex-1 text-center px-3 py-2 text-xs font-medium text-white rounded-lg"
                                            style="background: #EF4444;">
                                            Confirmer
                                        </button>
                                        <button wire:click="cancelRemove"
                                            class="px-3 py-2 text-xs font-medium rounded-lg"
                                            style="background: #F3F4F6; color: #4B5563;">
                                            Non
                                        </button>
                                    @else
                                        <button wire:click="confirmRemove({{ $connection->id }})"
                                            class="px-3 py-2 text-xs font-medium rounded-lg transition-all"
                                            style="background: #F3F4F6; color: #4B5563;"
                                            onmouseover="this.style.background='#FEF2F2'; this.style.color='#EF4444'"
                                            onmouseout="this.style.background='#F3F4F6'; this.style.color='#4B5563'">
                                            Retirer
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <!-- PROGRAMME FIDÉLITÉ -->
        @if($referralProgress['isActive'])
            <div class="bg-white rounded-xl border p-5" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 class="text-base font-semibold mb-3 flex items-center gap-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    <svg class="w-5 h-5" fill="#F59E0B" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    Programme fidélité
                </h2>
                <p class="text-sm mb-3" style="color: #4B5563;">
                    Invitez des amis à créer un compte Link-Card via votre profil et gagnez des mois Premium gratuits !
                </p>

                <!-- Barre de progression -->
                @php
                    $current = $referralProgress['current'];
                    $target = $referralProgress['target'];
                    $percent = $target > 0 ? ($current / $target * 100) : 0;
                @endphp
                <div class="mb-2">
                    <div class="flex justify-between text-xs font-medium mb-1">
                        <span style="color: #2C2A27;">{{ $current }}/{{ $target }} inscriptions</span>
                        @if($referralProgress['maxReached'])
                            <span style="color: #42B574;">Maximum atteint ! 🎉</span>
                        @else
                            <span style="color: #4B5563;">Encore {{ $target - $current }} pour 1 mois Premium</span>
                        @endif
                    </div>
                    <div class="w-full h-2.5 rounded-full" style="background: #E5E7EB;">
                        <div class="h-2.5 rounded-full transition-all duration-500" style="background: linear-gradient(90deg, #42B574, #F59E0B); width: {{ $percent }}%;"></div>
                    </div>
                </div>

                @if($referralProgress['bonusMonthsEarned'] > 0)
                    <p class="text-xs mt-2" style="color: #42B574;">
                        🎁 {{ $referralProgress['bonusMonthsEarned'] }} mois gratuit{{ $referralProgress['bonusMonthsEarned'] > 1 ? 's' : '' }} gagné{{ $referralProgress['bonusMonthsEarned'] > 1 ? 's' : '' }}
                        @if($referralProgress['bonusMonthsRemaining'] > 0)
                            · {{ $referralProgress['bonusMonthsRemaining'] }} restant{{ $referralProgress['bonusMonthsRemaining'] > 1 ? 's' : '' }}
                        @endif
                    </p>
                @endif
            </div>
        @endif

    </div>
</div>
