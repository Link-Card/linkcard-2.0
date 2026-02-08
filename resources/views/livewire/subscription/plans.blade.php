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
        <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
            @php
                $planOrder = ['free' => 0, 'pro' => 1, 'premium' => 2];
                $currentLevel = $planOrder[$currentPlan] ?? 0;
            @endphp
            
            @foreach($plans as $key => $plan)
                @php
                    $planLevel = $planOrder[$key] ?? 0;
                @endphp
                <div x-data="{ showFeatures: false }"
                     class="flex-1 bg-white rounded-xl shadow-sm border-2 transition-all {{ $currentPlan === $key ? 'border-[#42B574]' : 'border-transparent hover:border-[#D1D5DB]' }} {{ match($key) { 'free' => 'order-3 md:order-1', 'pro' => 'order-2 md:order-2', 'premium' => 'order-1 md:order-3', default => '' } }}">

                    <!-- Plan Header -->
                    <div class="p-5 sm:p-6">
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

                    <!-- CTA Button (en bas) -->
                    <div class="px-5 pb-5 sm:px-6 sm:pb-6">
                        @if($currentPlan === $key)
                            <button disabled class="w-full py-2.5 px-4 bg-[#E5E7EB] text-[#9CA3AF] rounded-lg font-medium text-sm cursor-not-allowed" style="font-family: 'Manrope', sans-serif;">
                                Plan actuel
                            </button>
                            @if($isAdminGranted)
                                <p class="text-center text-xs mt-2" style="color: #F59E0B; font-family: 'Manrope', sans-serif;">
                                    {{ $isSuperAdmin ? 'Plan administrateur (permanent)' : 'Attribué par l\'administrateur' }}
                                </p>
                            @endif
                        @elseif($isSuperAdmin)
                            {{-- Super admin ne voit pas les boutons de changement --}}
                        @elseif($isAdminGranted)
                            {{-- Plan admin-granted: pas de boutons Stripe --}}
                        @elseif($isSubscribed)
                            @if($planLevel > $currentLevel)
                                <button wire:click="redirectToPortal" class="w-full py-2.5 px-4 bg-[#42B574] text-white rounded-lg font-medium text-sm hover:bg-[#3DA367] transition-colors" style="font-family: 'Manrope', sans-serif;">
                                    Passer à {{ $plan['name'] }}
                                </button>
                            @else
                                <button wire:click="showDowngradeConfirm('{{ $key }}')" class="w-full py-2.5 px-4 border border-[#F59E0B] text-[#D97706] rounded-lg font-medium text-sm hover:bg-[#FEF3C7] transition-colors" style="font-family: 'Manrope', sans-serif;">
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
        @elseif($isAdminGranted)
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: #FEF3C7;">
                        <svg class="w-4 h-4" style="color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">
                        {{ $isSuperAdmin ? 'Plan administrateur' : 'Plan offert' }}
                    </h3>
                </div>
                <p class="text-[#4B5563] text-sm" style="font-family: 'Manrope', sans-serif;">
                    @if($isSuperAdmin)
                        Votre forfait Premium est permanent en tant que super administrateur. Aucune facturation.
                    @else
                        Votre forfait a été attribué par l'administrateur. Aucune facturation en cours.
                    @endif
                </p>
            </div>
        @endif

        {{-- Popup avertissement downgrade --}}
        @if($showDowngradeWarning)
            <div class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5);">
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 overflow-hidden">
                    <div class="px-6 pt-6 pb-4">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #FEF3C7;">
                                <svg class="w-5 h-5" style="color: #D97706;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                                Rétrograder au {{ $downgradeTo === 'free' ? 'Gratuit' : 'Pro' }} ?
                            </h3>
                        </div>

                        <div class="space-y-3" style="font-family: 'Manrope', sans-serif;">
                            <p class="text-sm" style="color: #4B5563;">
                                En changeant de forfait, vous perdrez l'accès à :
                            </p>

                            <div class="rounded-lg p-3 space-y-2" style="background: #FEF2F2; border: 1px solid #FCA5A5;">
                                @foreach($downgradeLosses as $loss)
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #EF4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="text-sm" style="color: #991B1B;">{{ $loss }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <p class="text-xs" style="color: #9CA3AF;">
                                Votre contenu masqué ne sera pas supprimé. Il redeviendra visible si vous passez à un forfait supérieur.
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 flex items-center space-x-3">
                        <button wire:click="confirmDowngrade"
                                class="flex-1 py-2.5 rounded-lg text-sm font-medium transition"
                                style="font-family: 'Manrope', sans-serif; background: #F59E0B; color: white;"
                                onmouseover="this.style.background='#D97706'"
                                onmouseout="this.style.background='#F59E0B'">
                            Continuer la rétrogradation
                        </button>
                        <button wire:click="cancelDowngrade"
                                class="flex-1 py-2.5 rounded-lg text-sm font-medium transition"
                                style="font-family: 'Manrope', sans-serif; color: #4B5563; border: 1.5px solid #D1D5DB;">
                            Garder mon forfait
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
