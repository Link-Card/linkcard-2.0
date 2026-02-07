{{-- Carte individuelle --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden transition-all" style="border: 1px solid #E5E7EB;">
    <div class="p-5">
        <div class="flex items-start justify-between">
            {{-- Gauche: Info carte --}}
            <div class="flex items-start space-x-4">
                {{-- Icône carte --}}
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background-color: {{ $card->is_active ? '#F0F9F4' : '#F3F4F6' }};">
                    <svg class="w-6 h-6" style="color: {{ $card->is_active ? '#42B574' : '#9CA3AF' }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/>
                    </svg>
                </div>

                <div>
                    {{-- Code carte --}}
                    <div class="flex items-center space-x-2">
                        <span class="font-mono text-sm font-semibold" style="color: #2C2A27;">
                            {{ $card->card_code }}
                        </span>
                        @if($card->is_active)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" 
                                  style="background-color: #F0F9F4; color: #42B574;">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                  style="background-color: #F3F4F6; color: #9CA3AF;">
                                Désactivée
                            </span>
                        @endif
                    </div>

                    {{-- URL de la carte --}}
                    <p class="text-xs mt-1" style="color: #9CA3AF;">
                        linkcard.ca/c/{{ $card->card_code }}
                    </p>

                    {{-- Stats inline --}}
                    <div class="flex items-center space-x-4 mt-2">
                        <span class="text-xs" style="color: #4B5563;">
                            <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ $card->scan_count }} scans
                        </span>
                        @if($card->last_scanned_at)
                            <span class="text-xs" style="color: #9CA3AF;">
                                Dernier: {{ $card->last_scanned_at->diffForHumans() }}
                            </span>
                        @endif
                        @if($card->activated_at)
                            <span class="text-xs" style="color: #9CA3AF;">
                                Activée: {{ $card->activated_at->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Droite: Actions --}}
            <div class="flex items-center space-x-2">
                {{-- Toggle actif/inactif --}}
                <button wire:click="toggleActive({{ $card->id }})"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                        style="background-color: {{ $card->is_active ? '#42B574' : '#D1D5DB' }};"
                        title="{{ $card->is_active ? 'Désactiver' : 'Activer' }}">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                          style="transform: translateX({{ $card->is_active ? '20px' : '0px' }});"></span>
                </button>
            </div>
        </div>

        {{-- Sélecteur de profil --}}
        <div class="mt-4 pt-4" style="border-top: 1px solid #E5E7EB;">
            <label class="block text-xs font-medium mb-2" style="color: #4B5563;">Profil lié</label>
            <div class="flex items-center space-x-3">
                {{-- Avatar profil actuel --}}
                @if($card->profile)
                    <div class="w-8 h-8 rounded-full flex-shrink-0 overflow-hidden"
                         style="background-color: {{ $card->profile->primary_color ?? '#42B574' }};">
                        @if($card->profile->photo_path)
                            <img src="{{ Storage::url($card->profile->photo_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white text-xs font-semibold">
                                {{ strtoupper(substr($card->profile->full_name ?? $card->profile->username, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Select profil --}}
                <select wire:change="updateProfile({{ $card->id }}, $event.target.value)"
                        class="flex-1 text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2"
                        style="border: 1px solid #D1D5DB; color: #2C2A27; focus-ring-color: #42B574;">
                    <option value="">— Aucun profil —</option>
                    @foreach($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ $card->profile_id == $profile->id ? 'selected' : '' }}>
                            {{ $profile->full_name ?? $profile->username }}
                            @if($profile->job_title) — {{ $profile->job_title }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
