<div class="min-h-screen bg-[#F7F8F4] py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-[#2C2A27]">Abonnement</h1>
            <p class="text-[#4B5563] mt-1">Choisissez le forfait adapté à vos besoins</p>
        </div>

        <!-- Toggle Mensuel/Annuel -->
        <div class="flex justify-center mb-8">
            <div class="bg-white rounded-lg p-1 shadow-sm inline-flex">
                <button 
                    wire:click="$set('billingCycle', 'monthly')"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $billingCycle === 'monthly' ? 'bg-[#42B574] text-white' : 'text-[#4B5563] hover:text-[#2C2A27]' }}"
                >
                    Mensuel
                </button>
                <button 
                    wire:click="$set('billingCycle', 'yearly')"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all {{ $billingCycle === 'yearly' ? 'bg-[#42B574] text-white' : 'text-[#4B5563] hover:text-[#2C2A27]' }}"
                >
                    Annuel
                    <span class="ml-1 text-xs {{ $billingCycle === 'yearly' ? 'text-white/80' : 'text-[#42B574]' }}">-17%</span>
                </button>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($plans as $key => $plan)
                <div class="bg-white rounded-xl shadow-sm border-2 transition-all {{ $currentPlan === $key ? 'border-[#42B574]' : 'border-transparent hover:border-[#D1D5DB]' }}">
                    <!-- Plan Header -->
                    <div class="p-6 border-b border-[#E5E7EB]">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-[#2C2A27]">{{ $plan['name'] }}</h3>
                            @if($currentPlan === $key)
                                <span class="px-2 py-1 bg-[#F0F9F4] text-[#42B574] text-xs font-medium rounded-full">Actuel</span>
                            @endif
                        </div>
                        
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-[#2C2A27]">
                                {{ $billingCycle === 'monthly' ? $plan['price_monthly'] : $plan['price_yearly'] }}$
                            </span>
                            <span class="text-[#4B5563] ml-1">
                                /{{ $billingCycle === 'monthly' ? 'mois' : 'an' }}
                            </span>
                        </div>
                        
                        @if($billingCycle === 'yearly' && $plan['price_yearly'] > 0)
                            <p class="text-sm text-[#42B574] mt-1">
                                Économisez {{ ($plan['price_monthly'] * 12) - $plan['price_yearly'] }}$/an
                            </p>
                        @endif
                    </div>

                    <!-- Features -->
                    <div class="p-6">
                        <ul class="space-y-3">
                            @foreach($plan['features'] as $feature)
                                <li class="flex items-start text-sm text-[#4B5563]">
                                    <svg class="w-5 h-5 text-[#42B574] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <div class="mt-6">
                            @if($currentPlan === $key)
                                <button disabled class="w-full py-2 px-4 bg-[#E5E7EB] text-[#9CA3AF] rounded-lg font-medium cursor-not-allowed">
                                    Plan actuel
                                </button>
                            @elseif($key === 'free')
                                @if($currentPlan !== 'free')
                                    <button class="w-full py-2 px-4 border border-[#D1D5DB] text-[#4B5563] rounded-lg font-medium hover:bg-[#F3F4F6] transition-colors">
                                        Rétrograder
                                    </button>
                                @endif
                            @else
                                <button 
                                    wire:click="subscribe('{{ $key }}')"
                                    class="w-full py-2 px-4 bg-[#42B574] text-white rounded-lg font-medium hover:bg-[#3DA367] transition-colors"
                                >
                                    {{ $currentPlan === 'free' ? 'Commencer' : 'Changer' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Manage Subscription (si abonné) -->
        @if($currentPlan !== 'free')
            <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-[#2C2A27] mb-4">Gérer mon abonnement</h3>
                <p class="text-[#4B5563] text-sm mb-4">
                    Modifiez votre méthode de paiement, consultez vos factures ou annulez votre abonnement.
                </p>
                <button 
                    wire:click="redirectToPortal"
                    class="px-4 py-2 border border-[#D1D5DB] text-[#4B5563] rounded-lg font-medium hover:bg-[#F3F4F6] transition-colors"
                >
                    Ouvrir le portail Stripe
                </button>
            </div>
        @endif
    </div>
</div>
