<div class="min-h-screen bg-[#F7F8F4] py-8">
    <div class="max-w-lg mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <!-- Icon succès -->
            <div class="w-16 h-16 mx-auto mb-6 bg-[#F0F9F4] rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-[#42B574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-[#2C2A27] mb-2" style="font-family: 'Manrope', sans-serif;">
                Paiement réussi !
            </h1>
            
            <p class="text-[#4B5563] mb-6" style="font-family: 'Manrope', sans-serif;">
                Bienvenue dans Link-Card <span class="font-semibold text-[#42B574]">{{ $planName }}</span> !
            </p>

            <div class="bg-[#F0F9F4] rounded-lg p-4 mb-6">
                <p class="text-sm text-[#2D7A4F]" style="font-family: 'Manrope', sans-serif;">
                    Votre abonnement est maintenant actif. Vous avez accès à toutes les fonctionnalités de votre forfait.
                </p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('profile.index') }}" class="block w-full py-3 px-4 bg-[#42B574] text-white rounded-lg font-medium hover:bg-[#3DA367] transition-colors" style="font-family: 'Manrope', sans-serif;">
                    Modifier mon profil
                </a>
                
                <a href="{{ route('subscription.plans') }}" class="block w-full py-3 px-4 border border-[#D1D5DB] text-[#4B5563] rounded-lg font-medium hover:bg-[#F3F4F6] transition-colors" style="font-family: 'Manrope', sans-serif;">
                    Voir mon abonnement
                </a>
            </div>
        </div>
    </div>
</div>
