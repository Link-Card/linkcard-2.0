<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Mes Profils</h1>
                <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                    <span class="font-medium">{{ $profilesCount }}/{{ $maxProfiles }}</span> profils utilisés
                </p>
            </div>

            @if($canCreateMore)
                <a href="{{ route('profile.create') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm"
                   style="font-family: 'Manrope', sans-serif; background: #42B574;"
                   onmouseover="this.style.background='#3DA367'"
                   onmouseout="this.style.background='#42B574'">
                    + Créer un profil
                </a>
            @else
                <button disabled class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-lg cursor-not-allowed"
                        style="font-family: 'Manrope', sans-serif; background: #E5E7EB; color: #9CA3AF;">
                    Limite atteinte
                </button>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                {{ session('success') }}
            </div>
        @endif

        @if($profiles->isEmpty())
            <div class="bg-white rounded-xl border p-10 sm:p-16 text-center" style="border-color: #E5E7EB;">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-4 sm:mb-6 flex items-center justify-center" style="background: #F0F9F4;">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="#42B574" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                </div>
                <h3 class="text-lg font-semibold mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Aucun profil</h3>
                <p class="text-sm mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Créez votre premier profil Link-Card</p>
                <a href="{{ route('profile.create') }}"
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white rounded-lg"
                   style="font-family: 'Manrope', sans-serif; background: #42B574;">
                    + Créer mon premier profil
                </a>
            </div>
        @else
            <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-3 sm:gap-6">
                @foreach($profiles as $profile)
                    {{-- Mobile: compact horizontal card --}}
                    <div class="bg-white rounded-xl border overflow-hidden sm:hidden" style="border-color: #E5E7EB;">
                        <div class="flex items-center p-4 gap-3">
                            <div class="flex-shrink-0">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-14 h-14 rounded-full object-cover" style="border: 2px solid {{ $profile->primary_color ?? '#42B574' }};">
                                @else
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, {{ $profile->primary_color ?? '#42B574' }}, {{ $profile->secondary_color ?? '#2D7A4F' }});">
                                        <span class="text-lg font-semibold text-white">{{ strtoupper(substr($profile->full_name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate" style="color: #2C2A27;">{{ $profile->full_name }}</p>
                                @if($profile->job_title)
                                    <p class="text-xs truncate" style="color: #4B5563;">{{ $profile->job_title }}</p>
                                @endif
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs font-mono px-1.5 py-0.5 rounded" style="background: #F3F4F6; color: #4B5563;">{{ $profile->username }}</span>
                                    <span class="text-xs" style="color: #9CA3AF;">{{ $profile->view_count }} vues</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 border-t" style="border-color: #E5E7EB;">
                            <a href="{{ route('profile.edit', $profile) }}" class="flex items-center justify-center py-2.5 text-xs font-medium transition-colors" style="color: #42B574;">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                Modifier
                            </a>
                            <a href="{{ route('profile.public', $profile->username) }}" target="_blank" class="flex items-center justify-center py-2.5 text-xs font-medium border-x transition-colors" style="color: #4A7FBF; border-color: #E5E7EB;">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Voir
                            </a>
                            <button wire:click="confirmReset({{ $profile->id }})" class="flex items-center justify-center py-2.5 text-xs font-medium transition-colors" style="color: #D97706;">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/></svg>
                                Reset
                            </button>
                        </div>
                    </div>

                    {{-- Desktop: original card with gradient --}}
                    <div class="hidden sm:block bg-white rounded-xl border overflow-hidden transition-all duration-200"
                         style="border-color: #E5E7EB;"
                         onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'"
                         onmouseout="this.style.boxShadow='none'">

                        <div class="h-28 relative" style="background: linear-gradient(135deg, {{ $profile->primary_color ?? '#42B574' }} 0%, {{ $profile->secondary_color ?? '#2D7A4F' }} 100%);">
                            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" class="w-20 h-20 rounded-full border-4 border-white object-cover shadow-lg">
                                @else
                                    <div class="w-20 h-20 rounded-full border-4 border-white flex items-center justify-center shadow-lg" style="background: #F3F4F6;">
                                        <span class="text-2xl font-semibold" style="color: #9CA3AF;">{{ strtoupper(substr($profile->full_name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-14 pb-5 px-5">
                            <h3 class="text-center font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $profile->full_name }}</h3>
                            @if($profile->job_title)
                                <p class="text-center text-sm mt-0.5" style="color: #4B5563;">{{ $profile->job_title }}</p>
                            @endif
                            @if($profile->company)
                                <p class="text-center text-xs mt-0.5" style="color: #9CA3AF;">{{ $profile->company }}</p>
                            @endif

                            <div class="flex items-center justify-center space-x-3 mt-3">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full" style="background: #F3F4F6; color: #4B5563;">{{ $profile->username }}</span>
                                <span class="text-xs" style="color: #9CA3AF;">{{ $profile->view_count }} vues</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-5">
                                <a href="{{ route('profile.public', $profile->username) }}" target="_blank"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="background: #EFF6FF; color: #4A7FBF;">
                                    Voir public
                                </a>
                                <a href="{{ route('profile.qr.download', $profile) }}"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="background: #F3F4F6; color: #4B5563;">
                                    QR Code
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <a href="{{ route('profile.edit', $profile) }}"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="background: #F0F9F4; color: #42B574;">
                                    Modifier
                                </a>
                                <button wire:click="confirmReset({{ $profile->id }})"
                                        class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                        style="background: #FEF3C7; color: #D97706;">
                                    Réinitialiser
                                </button>
                            </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Delete Modal -->
    <x-delete-modal :show="$showDeleteModal" :name="$deletingItemName" :type="$deletingItemType" action="reset" />
</div>
