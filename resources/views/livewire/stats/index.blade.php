<div class="min-h-screen bg-[#F7F8F4] py-8">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">Statistiques</h1>
            <p class="text-[#4B5563] mt-1 text-sm" style="font-family: 'Manrope', sans-serif;">Suivez les performances de votre profil</p>
        </div>

        @if(session()->has('error'))
            <div class="mb-4 p-3 rounded-lg bg-[#FEF2F2] border border-[#EF4444] text-[#991B1B] text-sm" style="font-family: 'Manrope', sans-serif;">
                {{ session('error') }}
            </div>
        @endif

        {{-- FREE: Upsell --}}
        @if(!$hasStats)
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                    <svg class="w-8 h-8" style="color: #42B574;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-[#2C2A27] mb-2" style="font-family: 'Manrope', sans-serif;">
                    Débloquez vos statistiques
                </h2>
                <p class="text-sm text-[#4B5563] mb-4 max-w-md mx-auto" style="font-family: 'Manrope', sans-serif;">
                    Découvrez qui visite votre profil, d'où viennent vos visiteurs et quels liens performent le mieux.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('subscription.plans') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium text-white transition"
                       style="font-family: 'Manrope', sans-serif; background: #42B574;"
                       onmouseover="this.style.background='#3DA367'"
                       onmouseout="this.style.background='#42B574'">
                        Passer à Pro — 5$/mois
                    </a>
                </div>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-lg mx-auto text-left">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5" style="color: #42B574;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-xs text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">Vues du profil par jour</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5" style="color: #42B574;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-xs text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">Sources de trafic</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5" style="color: #42B574;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-xs text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">Appareils (mobile/desktop)</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 mt-0.5" style="color: #9CA3AF;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-xs text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">Clics par lien <span class="text-[10px]">(Premium)</span></span>
                    </div>
                </div>
            </div>
        @else
            {{-- PRO/PREMIUM: Stats dashboard --}}

            {{-- Filtres --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <div class="flex items-center space-x-2">
                    @if($profiles->count() > 1)
                        <select wire:model.live="profileId"
                                class="px-3 py-2 rounded-lg text-sm border"
                                style="font-family: 'Manrope', sans-serif; border-color: #D1D5DB; color: #2C2A27;">
                            @foreach($profiles as $p)
                                <option value="{{ $p->id }}">{{ $p->full_name ?: $p->username }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div class="flex items-center space-x-2">
                    <div class="bg-white rounded-lg p-0.5 shadow-sm inline-flex border" style="border-color: #E5E7EB;">
                        @foreach(['7' => '7j', '30' => '30j', '90' => '90j'] as $val => $label)
                            <button wire:click="$set('period', '{{ $val }}')"
                                    class="px-3 py-1.5 rounded-md text-xs font-medium transition-all"
                                    style="font-family: 'Manrope', sans-serif; {{ $period === $val ? 'background: #42B574; color: white;' : 'color: #4B5563;' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    @if($isPremium)
                        <button wire:click="exportCsv"
                                class="px-3 py-1.5 rounded-lg text-xs font-medium transition inline-flex items-center space-x-1"
                                style="font-family: 'Manrope', sans-serif; border: 1px solid #D1D5DB; color: #4B5563;"
                                onmouseover="this.style.background='#F3F4F6'"
                                onmouseout="this.style.background='transparent'">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>CSV</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Cartes résumé --}}
            <div class="grid grid-cols-2 {{ $isPremium ? 'sm:grid-cols-4' : 'sm:grid-cols-3' }} gap-3 mb-6">
                {{-- Vues totales --}}
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs text-[#9CA3AF] mb-1" style="font-family: 'Manrope', sans-serif;">Vues totales</p>
                    <p class="text-2xl font-bold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">{{ number_format($totalViews) }}</p>
                </div>

                {{-- Vues période --}}
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs text-[#9CA3AF] mb-1" style="font-family: 'Manrope', sans-serif;">{{ $period }}  derniers jours</p>
                    <p class="text-2xl font-bold" style="font-family: 'Manrope', sans-serif; color: #42B574;">{{ number_format($periodViews) }}</p>
                </div>

                {{-- Moyenne par jour --}}
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs text-[#9CA3AF] mb-1" style="font-family: 'Manrope', sans-serif;">Moy. / jour</p>
                    <p class="text-2xl font-bold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">{{ $periodViews > 0 ? number_format($periodViews / (int)$period, 1) : '0' }}</p>
                </div>

                {{-- Clics (PREMIUM only) --}}
                @if($isPremium)
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <p class="text-xs text-[#9CA3AF] mb-1" style="font-family: 'Manrope', sans-serif;">Clics liens</p>
                        <p class="text-2xl font-bold" style="font-family: 'Manrope', sans-serif; color: #4A7FBF;">{{ number_format($totalClicks) }}</p>
                    </div>
                @endif
            </div>

            {{-- Graphique vues par jour --}}
            <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
                <h3 class="text-sm font-semibold text-[#2C2A27] mb-4" style="font-family: 'Manrope', sans-serif;">Vues par jour</h3>
                @if(array_sum($dailyViews) > 0)
                    <div class="relative" style="height: 200px;">
                        @php
                            $maxViews = max(1, max($dailyViews));
                            $barCount = count($dailyViews);
                        @endphp
                        <div class="flex items-end justify-between h-full gap-px">
                            @foreach($dailyViews as $date => $count)
                                @php
                                    $height = ($count / $maxViews) * 100;
                                    $isToday = $date === now()->format('Y-m-d');
                                @endphp
                                <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full mb-1 hidden group-hover:block z-10">
                                        <div class="bg-[#2C2A27] text-white text-[10px] px-2 py-1 rounded whitespace-nowrap" style="font-family: 'Manrope', sans-serif;">
                                            {{ \Carbon\Carbon::parse($date)->format('d/m') }} — {{ $count }} vue{{ $count > 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                    <div class="w-full rounded-t transition-all duration-200"
                                         style="height: {{ max(2, $height) }}%; background: {{ $isToday ? '#42B574' : '#D1FAE5' }}; min-height: 2px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Axe dates --}}
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">{{ \Carbon\Carbon::parse(array_key_first($dailyViews))->format('d/m') }}</span>
                            <span class="text-[10px] text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">Aujourd'hui</span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-center" style="height: 200px;">
                        <p class="text-sm text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">Aucune vue sur cette période</p>
                    </div>
                @endif
            </div>

            {{-- Breakdowns: Sources + Appareils --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                {{-- Sources --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-[#2C2A27] mb-3" style="font-family: 'Manrope', sans-serif;">Sources</h3>
                    @if(!empty($sourceBreakdown))
                        @php
                            $sourceLabels = [
                                'direct' => 'Direct',
                                'social' => 'Réseaux sociaux',
                                'search' => 'Recherche',
                                'referral' => 'Référence',
                                'internal' => 'LinkCard',
                                'nfc' => 'Carte NFC',
                            ];
                            $sourceColors = [
                                'direct' => '#42B574',
                                'social' => '#4A7FBF',
                                'search' => '#F59E0B',
                                'referral' => '#9CA3AF',
                                'internal' => '#2C2A27',
                                'nfc' => '#42B574',
                            ];
                            $totalSource = array_sum($sourceBreakdown);
                        @endphp
                        <div class="space-y-2.5">
                            @foreach($sourceBreakdown as $source => $count)
                                @php $pct = $totalSource > 0 ? round(($count / $totalSource) * 100) : 0; @endphp
                                <div>
                                    <div class="flex justify-between text-xs mb-1" style="font-family: 'Manrope', sans-serif;">
                                        <span class="text-[#4B5563]">{{ $sourceLabels[$source] ?? $source }}</span>
                                        <span class="text-[#9CA3AF]">{{ $count }} ({{ $pct }}%)</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full" style="background: #E5E7EB;">
                                        <div class="h-1.5 rounded-full transition-all" style="width: {{ $pct }}%; background: {{ $sourceColors[$source] ?? '#9CA3AF' }};"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">Aucune donnée</p>
                    @endif
                </div>

                {{-- Appareils --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-[#2C2A27] mb-3" style="font-family: 'Manrope', sans-serif;">Appareils</h3>
                    @if(!empty($deviceBreakdown))
                        @php
                            $deviceLabels = ['mobile' => 'Mobile', 'desktop' => 'Desktop', 'tablet' => 'Tablette', 'unknown' => 'Autre'];
                            $deviceIcons = [
                                'mobile' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                                'desktop' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                                'tablet' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                            ];
                            $totalDevice = array_sum($deviceBreakdown);
                        @endphp
                        <div class="space-y-3">
                            @foreach($deviceBreakdown as $device => $count)
                                @php $pct = $totalDevice > 0 ? round(($count / $totalDevice) * 100) : 0; @endphp
                                <div class="flex items-center space-x-3">
                                    <div class="text-[#4B5563]">{!! $deviceIcons[$device] ?? '' !!}</div>
                                    <div class="flex-1">
                                        <div class="flex justify-between text-xs mb-1" style="font-family: 'Manrope', sans-serif;">
                                            <span class="text-[#4B5563]">{{ $deviceLabels[$device] ?? $device }}</span>
                                            <span class="text-[#9CA3AF]">{{ $pct }}%</span>
                                        </div>
                                        <div class="w-full h-1.5 rounded-full" style="background: #E5E7EB;">
                                            <div class="h-1.5 rounded-full" style="width: {{ $pct }}%; background: #42B574;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-[#9CA3AF]" style="font-family: 'Manrope', sans-serif;">Aucune donnée</p>
                    @endif
                </div>
            </div>

            {{-- Top referers --}}
            @if(!empty($topReferers))
                <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
                    <h3 class="text-sm font-semibold text-[#2C2A27] mb-3" style="font-family: 'Manrope', sans-serif;">Top référents</h3>
                    <div class="space-y-2">
                        @foreach($topReferers as $domain => $count)
                            <div class="flex items-center justify-between py-1.5 border-b" style="border-color: #F3F4F6;">
                                <span class="text-sm text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">{{ $domain }}</span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="background: #F0F9F4; color: #42B574;">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- PREMIUM: Clics par lien --}}
            @if($isPremium)
                <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">Clics par lien</h3>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full" style="background: #EFF6FF; color: #4A7FBF;">PREMIUM</span>
                    </div>
                    @if(!empty($clicksByBand))
                        <div class="space-y-2">
                            @foreach($clicksByBand as $band)
                                <div class="flex items-center justify-between py-2 border-b" style="border-color: #F3F4F6;">
                                    <div class="flex items-center space-x-2">
                                        @if($band['type'] === 'social_link')
                                            <x-social-icon :platform="strtolower($band['label'])" size="w-4 h-4" />
                                        @elseif(($band['icon_type'] ?? '') === 'contact')
                                            <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2.75c1.24 0 2.25 1.01 2.25 2.25s-1.01 2.25-2.25 2.25S9.75 10.24 9.75 9s1.01-2.25 2.25-2.25zM17 17H7v-1.5c0-1.67 3.33-2.5 5-2.5s5 .83 5 2.5V17z"/></svg>
                                        @elseif(($band['icon_type'] ?? '') === 'button')
                                            <svg class="w-4 h-4" fill="#42B574" viewBox="0 0 24 24"><path d="M19 7H5c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm0 8H5V9h14v6z"/></svg>
                                        @elseif(($band['icon_type'] ?? '') === 'video')
                                            <svg class="w-4 h-4" fill="#DC2626" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        @elseif(($band['icon_type'] ?? '') === 'carousel')
                                            <svg class="w-4 h-4" fill="#D97706" viewBox="0 0 24 24"><path d="M2 6h4v11H2zm5-1h4v13H7zm5-1h4v15h-4zm5-1h4v17h-4z"/></svg>
                                        @else
                                            <svg class="w-4 h-4 text-[#9CA3AF]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        @endif
                                        <span class="text-sm text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">{{ $band['label'] }}</span>
                                    </div>
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="background: #EFF6FF; color: #4A7FBF;">{{ $band['count'] }} clic{{ $band['count'] > 1 ? 's' : '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-[#9CA3AF] py-4 text-center" style="font-family: 'Manrope', sans-serif;">Aucun clic enregistré sur cette période</p>
                    @endif
                </div>
            @elseif($plan === 'pro')
                {{-- PRO: Upsell clics --}}
                <div class="bg-white rounded-xl shadow-sm p-5 mb-6 opacity-70">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-[#2C2A27]" style="font-family: 'Manrope', sans-serif;">Clics par lien</h3>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full" style="background: #EFF6FF; color: #4A7FBF;">PREMIUM</span>
                    </div>
                    <div class="text-center py-4">
                        <p class="text-sm text-[#9CA3AF] mb-3" style="font-family: 'Manrope', sans-serif;">
                            Découvrez quels liens génèrent le plus de clics
                        </p>
                        <a href="{{ route('subscription.plans') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-medium transition"
                           style="font-family: 'Manrope', sans-serif; background: #EFF6FF; color: #4A7FBF;"
                           onmouseover="this.style.background='#DBEAFE'"
                           onmouseout="this.style.background='#EFF6FF'">
                            Passer à Premium
                        </a>
                    </div>
                </div>
            @endif

        @endif
    </div>
</div>
