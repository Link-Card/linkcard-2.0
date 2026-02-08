<div class="space-y-6" style="font-family: 'Manrope', sans-serif;">

    {{-- Résumé rapide --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        {{-- Utilisateurs par plan --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs" style="color: #9CA3AF;">Free</p>
            <p class="text-2xl font-bold" style="color: #2C2A27;">{{ $stats['freeUsers'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs" style="color: #9CA3AF;">Pro</p>
            <p class="text-2xl font-bold" style="color: #42B574;">{{ $stats['proUsers'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs" style="color: #9CA3AF;">Premium</p>
            <p class="text-2xl font-bold" style="color: #4A7FBF;">{{ $stats['premiumUsers'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs" style="color: #9CA3AF;">Taux conversion</p>
            <p class="text-2xl font-bold" style="color: #F59E0B;">{{ $adminStats['conversionRate'] }}%</p>
            <p class="text-[10px]" style="color: #9CA3AF;">{{ $adminStats['upgradedUsers'] }} payants</p>
        </div>
    </div>

    {{-- Comparaisons semaine/mois --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold mb-3" style="color: #2C2A27;">Inscriptions cette semaine</h3>
            <div class="flex items-end space-x-3">
                <span class="text-3xl font-bold" style="color: #42B574;">{{ $adminStats['thisWeek'] }}</span>
                @php
                    $weekDiff = $adminStats['thisWeek'] - $adminStats['lastWeek'];
                    $weekColor = $weekDiff >= 0 ? '#42B574' : '#EF4444';
                    $weekArrow = $weekDiff >= 0 ? '↑' : '↓';
                @endphp
                <span class="text-sm font-medium pb-1" style="color: {{ $weekColor }};">
                    {{ $weekArrow }} {{ abs($weekDiff) }} vs semaine dernière ({{ $adminStats['lastWeek'] }})
                </span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold mb-3" style="color: #2C2A27;">Inscriptions ce mois</h3>
            <div class="flex items-end space-x-3">
                <span class="text-3xl font-bold" style="color: #42B574;">{{ $adminStats['thisMonth'] }}</span>
                @php
                    $monthDiff = $adminStats['thisMonth'] - $adminStats['lastMonth'];
                    $monthColor = $monthDiff >= 0 ? '#42B574' : '#EF4444';
                    $monthArrow = $monthDiff >= 0 ? '↑' : '↓';
                @endphp
                <span class="text-sm font-medium pb-1" style="color: {{ $monthColor }};">
                    {{ $monthArrow }} {{ abs($monthDiff) }} vs mois dernier ({{ $adminStats['lastMonth'] }})
                </span>
            </div>
        </div>
    </div>

    {{-- Graphique inscriptions 30 jours --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold mb-4" style="color: #2C2A27;">Inscriptions — 30 derniers jours</h3>
        @if(array_sum($adminStats['signupsByDay']) > 0)
            <div class="relative" style="height: 180px;">
                @php $maxSignups = max(1, max($adminStats['signupsByDay'])); @endphp
                <div class="flex items-end justify-between h-full gap-px">
                    @foreach($adminStats['signupsByDay'] as $date => $count)
                        @php
                            $height = ($count / $maxSignups) * 100;
                            $isToday = $date === now()->format('Y-m-d');
                        @endphp
                        <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
                            <div class="absolute bottom-full mb-1 hidden group-hover:block z-10">
                                <div class="bg-[#2C2A27] text-white text-[10px] px-2 py-1 rounded whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($date)->format('d/m') }} — {{ $count }} inscription{{ $count > 1 ? 's' : '' }}
                                </div>
                            </div>
                            <div class="w-full rounded-t transition-all duration-200"
                                 style="height: {{ max(2, $height) }}%; background: {{ $isToday ? '#42B574' : '#D1FAE5' }}; min-height: 2px;">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-2">
                    <span class="text-[10px]" style="color: #9CA3AF;">{{ \Carbon\Carbon::parse(array_key_first($adminStats['signupsByDay']))->format('d/m') }}</span>
                    <span class="text-[10px]" style="color: #9CA3AF;">Aujourd'hui</span>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center" style="height: 180px;">
                <p class="text-sm" style="color: #9CA3AF;">Aucune inscription sur cette période</p>
            </div>
        @endif
    </div>

    {{-- Graphique vues profils 30 jours --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold" style="color: #2C2A27;">Vues profils — 30 derniers jours</h3>
            <div class="flex items-center space-x-4 text-xs" style="color: #9CA3AF;">
                <span>Total: <strong style="color: #2C2A27;">{{ number_format($adminStats['totalProfileViews']) }}</strong></span>
                <span>Clics: <strong style="color: #4A7FBF;">{{ number_format($adminStats['totalClicks']) }}</strong></span>
            </div>
        </div>
        @if(array_sum($adminStats['viewsByDay']) > 0)
            <div class="relative" style="height: 180px;">
                @php $maxViews = max(1, max($adminStats['viewsByDay'])); @endphp
                <div class="flex items-end justify-between h-full gap-px">
                    @foreach($adminStats['viewsByDay'] as $date => $count)
                        @php
                            $height = ($count / $maxViews) * 100;
                            $isToday = $date === now()->format('Y-m-d');
                        @endphp
                        <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
                            <div class="absolute bottom-full mb-1 hidden group-hover:block z-10">
                                <div class="bg-[#2C2A27] text-white text-[10px] px-2 py-1 rounded whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($date)->format('d/m') }} — {{ $count }} vue{{ $count > 1 ? 's' : '' }}
                                </div>
                            </div>
                            <div class="w-full rounded-t transition-all duration-200"
                                 style="height: {{ max(2, $height) }}%; background: {{ $isToday ? '#4A7FBF' : '#BFDBFE' }}; min-height: 2px;">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-2">
                    <span class="text-[10px]" style="color: #9CA3AF;">{{ \Carbon\Carbon::parse(array_key_first($adminStats['viewsByDay']))->format('d/m') }}</span>
                    <span class="text-[10px]" style="color: #9CA3AF;">Aujourd'hui</span>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center" style="height: 180px;">
                <p class="text-sm" style="color: #9CA3AF;">Aucune vue sur cette période</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Top profils --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold mb-3" style="color: #2C2A27;">Top profils (30j)</h3>
            @if(!empty($adminStats['topProfiles']))
                <div class="space-y-2">
                    @foreach($adminStats['topProfiles'] as $i => $tp)
                        <div class="flex items-center justify-between py-1.5 {{ !$loop->last ? 'border-b' : '' }}" style="border-color: #F3F4F6;">
                            <div class="flex items-center space-x-2">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white" style="background: {{ $i === 0 ? '#42B574' : ($i === 1 ? '#4A7FBF' : '#9CA3AF') }};">{{ $i + 1 }}</span>
                                <div>
                                    <span class="text-sm" style="color: #2C2A27;">{{ $tp['name'] ?: $tp['username'] }}</span>
                                    <span class="text-xs ml-1" style="color: #9CA3AF;">{{ $tp['username'] }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full" style="background: #F0F9F4; color: #42B574;">{{ $tp['views'] }} vues</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs" style="color: #9CA3AF;">Aucune donnée</p>
            @endif
        </div>

        {{-- Revenus cartes NFC (6 mois) --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold mb-3" style="color: #2C2A27;">Revenus cartes NFC (6 mois)</h3>
            @if(array_sum($adminStats['revenueByMonth']) > 0)
                <div class="space-y-2">
                    @php $maxRev = max(1, max($adminStats['revenueByMonth'])); @endphp
                    @foreach($adminStats['revenueByMonth'] as $month => $cents)
                        @php $pct = ($cents / $maxRev) * 100; @endphp
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span style="color: #4B5563;">{{ $month }}</span>
                                <span style="color: #2C2A27; font-weight: 600;">{{ number_format($cents / 100, 2) }}$</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full" style="background: #E5E7EB;">
                                <div class="h-1.5 rounded-full" style="width: {{ max(2, $pct) }}%; background: #42B574;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs" style="color: #9CA3AF;">Aucun revenu sur cette période</p>
            @endif
        </div>
    </div>

    {{-- Répartition des plans (barre horizontale) --}}
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold mb-3" style="color: #2C2A27;">Répartition des forfaits</h3>
        @php
            $total = $stats['freeUsers'] + $stats['proUsers'] + $stats['premiumUsers'];
            $freePct = $total > 0 ? round(($stats['freeUsers'] / $total) * 100) : 0;
            $proPct = $total > 0 ? round(($stats['proUsers'] / $total) * 100) : 0;
            $premPct = $total > 0 ? round(($stats['premiumUsers'] / $total) * 100) : 0;
        @endphp
        <div class="flex rounded-full overflow-hidden h-4 mb-3" style="background: #E5E7EB;">
            @if($freePct > 0)
                <div style="width: {{ $freePct }}%; background: #9CA3AF;" class="transition-all"></div>
            @endif
            @if($proPct > 0)
                <div style="width: {{ $proPct }}%; background: #42B574;" class="transition-all"></div>
            @endif
            @if($premPct > 0)
                <div style="width: {{ $premPct }}%; background: #4A7FBF;" class="transition-all"></div>
            @endif
        </div>
        <div class="flex justify-between text-xs">
            <div class="flex items-center space-x-1.5">
                <div class="w-2.5 h-2.5 rounded-full" style="background: #9CA3AF;"></div>
                <span style="color: #4B5563;">Free {{ $stats['freeUsers'] }} ({{ $freePct }}%)</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <div class="w-2.5 h-2.5 rounded-full" style="background: #42B574;"></div>
                <span style="color: #4B5563;">Pro {{ $stats['proUsers'] }} ({{ $proPct }}%)</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <div class="w-2.5 h-2.5 rounded-full" style="background: #4A7FBF;"></div>
                <span style="color: #4B5563;">Premium {{ $stats['premiumUsers'] }} ({{ $premPct }}%)</span>
            </div>
        </div>
    </div>
</div>
