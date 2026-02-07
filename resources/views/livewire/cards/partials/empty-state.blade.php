{{-- Empty state - aucune carte --}}
<div class="bg-white rounded-2xl shadow-sm p-12 text-center" style="border: 1px solid #E5E7EB;">
    <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
        <svg class="w-10 h-10" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
    </div>

    <h3 class="text-lg font-semibold mb-2" style="color: #2C2A27;">Aucune carte NFC</h3>
    <p class="text-sm mb-8 max-w-sm mx-auto" style="color: #4B5563;">
        Commandez votre première carte NFC et partagez votre profil d'un simple tap.
    </p>

    <a href="{{ route('cards.order') }}"
       class="inline-block px-6 py-3 rounded-lg text-white font-medium transition-colors"
       style="background-color: #42B574;"
       onmouseover="this.style.backgroundColor='#3DA367'"
       onmouseout="this.style.backgroundColor='#42B574'">
        Commander ma première carte
    </a>

    <p class="text-xs mt-4" style="color: #9CA3AF;">
        À partir de 37.49$ (PREMIUM) · Livraison au Canada
    </p>
</div>
