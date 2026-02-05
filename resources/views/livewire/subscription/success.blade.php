<div class="min-h-screen bg-[#F7F8F4] py-8">
    <div class="max-w-lg mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <div class="w-16 h-16 bg-[#F0F9F4] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#42B574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-[#2C2A27] mb-2">Paiement réussi!</h1>
            <p class="text-[#4B5563] mb-6">Votre abonnement est maintenant actif.</p>
            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-[#42B574] text-white rounded-lg font-medium hover:bg-[#3DA367] transition-colors">
                Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
