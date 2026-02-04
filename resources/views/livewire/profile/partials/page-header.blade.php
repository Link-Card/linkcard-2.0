<div class="max-w-7xl mx-auto pt-6 pb-4 px-4 sm:px-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">
                Modifier le profil
            </h1>
            <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                {{ $profile->username }}
                <span class="mx-1">·</span>
                <a href="{{ route('profile.public', $profile->username) }}" target="_blank"
                   class="transition" style="color: #42B574;"
                   onmouseover="this.style.textDecoration='underline'"
                   onmouseout="this.style.textDecoration='none'">
                    Voir le profil public ↗
                </a>
            </p>
        </div>
        <div x-show="savedShow" x-transition.opacity.duration.300ms
             class="flex items-center space-x-1.5 px-3 py-1.5 rounded-full"
             style="background: #F0F9F4; color: #42B574; font-family: 'Manrope', sans-serif; font-size: 13px; font-weight: 500;">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Sauvegardé</span>
        </div>
    </div>
</div>
