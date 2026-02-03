<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">Mes Profils</h1>
                <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                    <span class="font-medium">{{ $profilesCount }}/{{ $maxProfiles }}</span> profils utilisés
                </p>
            </div>
            
            @if($canCreateMore)
                <a href="{{ route('profile.create') }}" 
                   class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm"
                   style="font-family: 'Manrope', sans-serif; background: #42B574;"
                   onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'"
                   onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
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
            <!-- État vide -->
            <div class="bg-white rounded-xl border p-16 text-center" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center" style="background: #F0F9F4;">
                    <span class="text-4xl">📇</span>
                </div>
                <h3 class="text-lg font-semibold mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Aucun profil</h3>
                <p class="text-sm mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Créez votre premier profil Link-Card pour commencer</p>
                <a href="{{ route('profile.create') }}" 
                   class="inline-flex items-center px-6 py-3 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm"
                   style="font-family: 'Manrope', sans-serif; background: #42B574;"
                   onmouseover="this.style.background='#3DA367'"
                   onmouseout="this.style.background='#42B574'">
                    + Créer mon premier profil
                </a>
            </div>
        @else
            <!-- Grille profils -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($profiles as $profile)
                    <div class="bg-white rounded-xl border overflow-hidden transition-all duration-200"
                         style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                         onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'; this.style.transform='translateY(-2px)'"
                         onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                        
                        <!-- Header dégradé -->
                        <div class="h-28 relative" style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%);">
                            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                                @if($profile->photo_path)
                                    <img src="{{ Storage::url($profile->photo_path) }}" 
                                         alt="{{ $profile->full_name }}"
                                         class="w-20 h-20 rounded-full border-4 border-white object-cover" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                @else
                                    <div class="w-20 h-20 rounded-full border-4 border-white flex items-center justify-center" 
                                         style="background: #F3F4F6; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                        <span class="text-2xl font-semibold" style="color: #9CA3AF;">{{ strtoupper(substr($profile->full_name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="pt-14 pb-5 px-5">
                            <h3 class="text-center font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $profile->full_name }}</h3>
                            @if($profile->job_title)
                                <p class="text-center text-sm mt-0.5" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $profile->job_title }}</p>
                            @endif
                            @if($profile->company)
                                <p class="text-center text-xs mt-0.5" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $profile->company }}</p>
                            @endif

                            <!-- Code + Vues -->
                            <div class="flex items-center justify-center space-x-3 mt-3">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full" style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;">
                                    {{ $profile->username }}
                                </span>
                                <span class="text-xs" style="color: #9CA3AF;">{{ $profile->view_count }} vues</span>
                            </div>

                            <!-- Actions -->
                            <div class="grid grid-cols-2 gap-2 mt-5">
                                <a href="{{ route('profile.public', $profile->username) }}" target="_blank"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="font-family: 'Manrope', sans-serif; background: #EFF6FF; color: #4A7FBF;"
                                   onmouseover="this.style.background='#DBEAFE'"
                                   onmouseout="this.style.background='#EFF6FF'">
                                    👁️ Voir public
                                </a>
                                <a href="{{ route('profile.qr.download', $profile) }}"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;"
                                   onmouseover="this.style.background='#E5E7EB'"
                                   onmouseout="this.style.background='#F3F4F6'">
                                    📥 QR Code
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <a href="{{ route('profile.edit', $profile) }}"
                                   class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                   style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574;"
                                   onmouseover="this.style.background='#DCFCE7'"
                                   onmouseout="this.style.background='#F0F9F4'">
                                    ✏️ Modifier
                                </a>
                                <button wire:click="delete({{ $profile->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce profil ?"
                                        class="text-center py-2 px-3 text-xs font-medium rounded-lg transition-colors"
                                        style="font-family: 'Manrope', sans-serif; background: #FEF2F2; color: #EF4444;"
                                        onmouseover="this.style.background='#FEE2E2'"
                                        onmouseout="this.style.background='#FEF2F2'">
                                    🗑️ Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
