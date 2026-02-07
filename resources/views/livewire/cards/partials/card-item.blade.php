<div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Card info -->
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 {{ $card->is_active ? '' : 'opacity-50' }}" style="background-color: #F0F9F4;">
                <svg class="w-6 h-6" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <span class="font-mono font-semibold" style="color: #2C2A27;">{{ $card->card_code }}</span>
                    @if($card->is_active)
                        <span class="px-2 py-0.5 text-xs rounded-full font-medium" style="background-color: #F0F9F4; color: #42B574;">Actif</span>
                    @else
                        <span class="px-2 py-0.5 text-xs rounded-full font-medium" style="background-color: #F3F4F6; color: #9CA3AF;">Inactif</span>
                    @endif
                </div>
                <p class="text-xs mt-1" style="color: #9CA3AF;">
                    {{ $card->scan_count }} scans
                    @if($card->last_scanned_at)
                        · Dernier: {{ $card->last_scanned_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Profile selector -->
            <select wire:change="updateProfile({{ $card->id }}, $event.target.value)" class="text-sm rounded-lg border px-3 py-2 flex-1 sm:flex-none" style="border-color: #D1D5DB; color: #2C2A27;">
                <option value="">— Aucun profil —</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}" {{ $card->profile_id == $profile->id ? 'selected' : '' }}>
                        {{ $profile->full_name ?? $profile->username }}
                    </option>
                @endforeach
            </select>

            <!-- Toggle active -->
            <button wire:click="toggleActive({{ $card->id }})" wire:loading.attr="disabled" wire:target="toggleActive({{ $card->id }})" class="p-2 rounded-lg transition-colors disabled:opacity-40 flex-shrink-0" style="color: {{ $card->is_active ? '#42B574' : '#9CA3AF' }};" title="{{ $card->is_active ? 'Désactiver' : 'Activer' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($card->is_active)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    @endif
                </svg>
            </button>
        </div>
    </div>
</div>
