<div class="min-h-screen bg-[#F7F8F4] py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">Abonnement</h1>
            <p class="text-[#4B5563] mt-1" style="font-family: 'Manrope', sans-serif;">Choisissez le forfait adapté à vos besoins</p>
        </div>

        <!-- Success Message (retour du portail) -->
        @if($showSuccessMessage)
            <div class="mb-6 p-4 rounded-lg bg-[#F0F9F4] border border-[#42B574]" style="font-family: 'Manrope', sans-serif;">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-[#42B574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <div>
                        <p class="font-medium text-[#2D7A4F]">Modifications enregistrées!</p>
                        <p class="text-sm text-[#4B5563]">Votre abonnement a été mis à jour avec succès.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Messages -->
        @if(session()->has('success'))
            <div class="mb-6 p-4 rounded-lg bg-[#F0F9F4] border border-[#42B574] text-[#2D7A4F]" style="font-family: 'Manrope', sans-serif;">
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="mb-6 p-4 rounded-lg bg-[#FEF2F2] border border-[#EF4444] text-[#991B1B]" style="font-family: 'Manrope', sans-serif;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Grace Period Notice -->
        @if($onGracePeriod)
            <div class="mb-6 p-4 rounded-lg bg-[#FEF3C7] border border-[#F59E0B]" style="font-family: 'Manrope', sans-serif;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-[#92400E]">Votre abonnement se termine le {{ $endsAt->format('d/m/Y') }}</p>
                        <p class="text-sm text-[#B45309]">Vous conservez l'accès à vos fonctionnalités jusqu'à cette date.</p>
                    </div>
                    <button wire:click="redirectToPortal" class="px-4 py-2 bg-[#F59E0B] text-white rounded-lg font-medium hover:bg-[#D97706] transition-colors">
                        Reprendre
                    </button>
                </div>
            </div>
        @endif

        <!-- Toggle Mensuel/Annuel -->
        <div class="flex justify-center mb-8">
            <div class="bg-white rounded-lg p-1 shadow-sm inline-flex">
                <button
                    wire:click="$set('billingCycle', 'monthly')"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $billingCycle === 'monthly' ? 'bg-[#42B574] text-white' : 'text-[#4B5563] hover:text-[#2C2A27]' }}"
                    style="font-family: 'Manrope', sans-serif;"
                >
                    Mensuel
                </button>
                <button
                    wire:click="$set('billingCycle', 'yearly')"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $billingCycle === 'yearly' ? 'bg-[#42B574] text-white' : 'text-[#4B5563] hover:text-[#2C2A27]' }}"
                    style="font-family: 'Manrope', sans-serif;"
                >
                    Annuel
                    <span class="ml-1 text-xs {{ $billingCycle === 'yearly' ? 'text-white/80' : 'text-[#42B574]' }}">-17%</span>
                </button>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-3 gap-4 sm:gap-6">
            @php
                $planOrder = ['free' => 0, 'pro' => 1, 'premium' => 2];
                $currentLevel = $planOrder[$currentPlan] ?? 0;
            @endphp
            
            @foreach($plans as $key => $plan)
                @php $planLevel = $planOrder[$key] ?? 0; @endphp
                <div x-data="{ showFeatures: false }"
                     class="bg-white rounded-xl shadow-sm border-2 transition-all {{ $currentPlan === $key ? 'border-[#42B574]' : 'border-transparent hover:border-[#D1D5DB]' }} {{ $key === 'premium' ? 'ring-1 ring-[#42B574]/20' : '' }}">
                    
                    {{-- Recommended badge for Premium --}}
                    @if($key === 'premium')
                        <div class="text-center py-1.5 text-xs font-semibold text-white rounded-t-lg" style="background: #42B574;">
                            Recommandé
                        </div>
                    @endif

                    <!-- Plan Header -->
                    <div class="p-5 sm:p-6 {{ $key !== 'premium' ? '' : '' }}">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">{{ $plan['name'] }}</h3>
                            @if($currentPlan === $key)
                                <span class="px-2 py-1 bg-[#F0F9F4] text-[#42B574] text-xs font-medium rounded-full">Actuel</span>
                            @endif
                        </div>

                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">
                                {{ $billingCycle === 'monthly' ? $plan['price_monthly'] : $plan['price_yearly'] }}$
                            </span>
                            <span class="text-[#4B5563] ml-1 text-sm" style="font-family: 'Manrope', sans-serif;">
                                /{{ $billingCycle === 'monthly' ? 'mois' : 'an' }}
                            </span>
                        </div>

                        @if($billingCycle === 'yearly' && $plan['price_yearly'] > 0)
                            <p class="text-sm text-[#42B574] mt-1" style="font-family: 'Manrope', sans-serif;">
                                Économisez {{ ($plan['price_monthly'] * 12) - $plan['price_yearly'] }}$/an
                            </p>
                        @endif

                        <!-- CTA Button -->
                        <div class="mt-4">
                            @if($currentPlan === $key)
                                <button disabled class="w-full py-2.5 px-4 bg-[#E5E7EB] text-[#9CA3AF] rounded-lg font-medium text-sm cursor-not-allowed" style="font-family: 'Manrope', sans-serif;">
                                    Plan actuel
                                </button>
                            @elseif($isSubscribed)
                                @if($planLevel > $currentLevel)
                                    <button wire:click="redirectToPortal" class="w-full py-2.5 px-4 bg-[#42B574] text-white rounded-lg font-medium text-sm hover:bg-[#3DA367] transition-colors" style="font-family: 'Manrope', sans-serif;">
                                        Passer à {{ $plan['name'] }}
                                    </button>
                                @else
                                    <button wire:click="redirectToPortal" class="w-full py-2.5 px-4 border border-[#F59E0B] text-[#D97706] rounded-lg font-medium text-sm hover:bg-[#FEF3C7] transition-colors" style="font-family: 'Manrope', sans-serif;">
                                        Rétrograder
                                    </button>
                                @endif
                            @elseif($key !== 'free')
                                <button wire:click="subscribe('{{ $key }}')" wire:loading.attr="disabled" class="w-full py-2.5 px-4 bg-[#42B574] text-white rounded-lg font-medium text-sm hover:bg-[#3DA367] transition-colors disabled:opacity-50" style="font-family: 'Manrope', sans-serif;">
                                    <span wire:loading.remove wire:target="subscribe">Commencer</span>
                                    <span wire:loading wire:target="subscribe" class="flex items-center justify-center">
                                        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        Chargement...
                                    </span>
                                </button>
                            @endif
                        </div>

                        <!-- Features toggle (mobile) / always visible (desktop) -->
                        <button @click="showFeatures = !showFeatures" class="md:hidden w-full mt-3 flex items-center justify-center text-xs font-medium py-2 rounded-lg transition-colors" style="color: #4B5563;">
                            <span x-text="showFeatures ? 'Masquer le détail' : 'Voir le détail'"></span>
                            <svg class="w-4 h-4 ml-1 transition-transform" :class="showFeatures && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>

                    <!-- Features list -->
                    <div class="border-t border-[#E5E7EB] p-5 sm:p-6" :class="{ 'hidden md:block': !showFeatures }">
                        <ul class="space-y-2.5">
                            @foreach($plan['features'] as $feature)
                                <li class="flex items-start text-sm text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">
                                    <svg class="w-4 h-4 text-[#42B574] mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Manage Subscription (si abonné) -->
        @if($isSubscribed)
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-[#2C2A27] mb-4" style="font-family: 'Manrope', sans-serif;">Gérer mon abonnement</h3>
                <p class="text-[#4B5563] text-sm mb-4" style="font-family: 'Manrope', sans-serif;">
                    Modifiez votre forfait, méthode de paiement, consultez vos factures ou annulez votre abonnement.
                </p>
                <button
                    wire:click="redirectToPortal"
                    class="px-4 py-2 border border-[#D1D5DB] text-[#4B5563] rounded-lg font-medium hover:bg-[#F3F4F6] transition-colors"
                    style="font-family: 'Manrope', sans-serif;"
                >
                    Ouvrir le portail de facturation
                </button>
            </div>
        @endif
    </div>
</div>
