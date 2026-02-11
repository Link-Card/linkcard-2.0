@php
    $tourStep = (int) request()->query('tour', 0);
    if ($tourStep < 1 || $tourStep > 4) return;

    $user = auth()->user();
    $profile = $user?->profiles()->first();

    $steps = [
        1 => [
            'title' => 'Votre éditeur de profil',
            'description' => 'C\'est ici que vous personnalisez votre carte Link-Card : photo, infos, liens sociaux, template et couleurs.',
            'icon_bg' => '#F0F9F4',
            'icon_border' => '#D1FAE5',
            'badge_bg' => '#42B574',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>',
            'next_url' => route('stats.index', ['tour' => 2]),
            'next_label' => 'Statistiques',
            'step_label' => '1/4',
        ],
        2 => [
            'title' => 'Vos statistiques',
            'description' => 'Suivez qui visite votre profil, quels liens sont les plus cliqués et d\'où viennent vos visiteurs.',
            'icon_bg' => '#FFF1F2',
            'icon_border' => '#FECDD3',
            'badge_bg' => '#E11D48',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
            'next_url' => route('cards.index', ['tour' => 3]),
            'next_label' => 'Cartes NFC',
            'step_label' => '2/4',
        ],
        3 => [
            'title' => 'Vos cartes NFC',
            'description' => 'Commandez votre carte physique et partagez votre profil d\'un simple geste. Un tap sur un téléphone suffit!',
            'icon_bg' => '#EFF6FF',
            'icon_border' => '#BFDBFE',
            'badge_bg' => '#4A7FBF',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>',
            'next_url' => route('subscription.plans', ['tour' => 4]),
            'next_label' => 'Forfaits',
            'step_label' => '3/4',
        ],
        4 => [
            'title' => 'Votre forfait',
            'description' => 'Débloquez plus de sections, de templates et le QR Code avec les forfaits Pro et Premium. Commencez gratuitement!',
            'icon_bg' => '#F3F0FF',
            'icon_border' => '#DDD6FE',
            'badge_bg' => '#8B5CF6',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>',
            'next_url' => route('subscription.plans'),
            'next_label' => 'C\'est parti!',
            'step_label' => '4/4',
            'is_last' => true,
        ],
    ];

    $current = $steps[$tourStep] ?? null;
    if (!$current) return;

    $dismissUrl = route('dashboard');
@endphp

{{-- Desktop: centered popup with light overlay --}}
<div x-data="{ show: true }" x-show="show" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[9999] hidden lg:flex items-center justify-center p-4"
     style="background: rgba(0,0,0,0.25); backdrop-filter: blur(1px);">

    <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden relative"
         style="box-shadow: 0 25px 50px rgba(0,0,0,0.15);">

        @if($current['step_label'])
        <div class="absolute top-4 left-5">
            <span class="text-xs font-medium px-2.5 py-1 rounded-full" style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;">
                {{ $current['step_label'] }}
            </span>
        </div>
        @endif

        <a href="{{ $dismissUrl }}" class="absolute top-4 right-4 text-xs px-2.5 py-1 rounded-full transition-colors" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
            Passer ✕
        </a>

        <div class="pt-10 pb-5 px-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: {{ $current['icon_bg'] }};">
                <svg class="w-8 h-8" fill="none" stroke="{{ $current['badge_bg'] }}" stroke-width="1.5" viewBox="0 0 24 24">{!! $current['icon'] !!}</svg>
            </div>

            <div class="p-4 rounded-xl text-left mb-4" style="background: {{ $current['icon_bg'] }}; border: 1px solid {{ $current['icon_border'] }};">
                <div class="flex items-center space-x-2.5 mb-1.5">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0" style="background: {{ $current['badge_bg'] }};">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $current['icon'] !!}</svg>
                    </div>
                    <span class="font-semibold text-sm" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $current['title'] }}</span>
                </div>
                <p class="text-xs leading-relaxed" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $current['description'] }}</p>
            </div>

            <div class="flex items-center justify-center space-x-2 mb-4">
                @for($i = 1; $i <= 4; $i++)
                    <div class="rounded-full {{ $i === $tourStep ? 'w-2.5 h-2.5' : 'w-2 h-2' }}" style="background: {{ $i === $tourStep ? '#42B574' : ($i < $tourStep ? '#42B574' : '#D1D5DB') }}; {{ $i < $tourStep ? 'opacity: 0.5;' : '' }}"></div>
                @endfor
            </div>

            <a href="{{ $current['next_url'] }}" class="block w-full py-3 px-6 rounded-xl text-white font-medium text-sm text-center transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: {{ $current['badge_bg'] }};" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                @if($current['is_last'] ?? false)
                    {{ $current['next_label'] }}
                @else
                    Suivant : {{ $current['next_label'] }} →
                @endif
            </a>
        </div>
    </div>
</div>

{{-- Mobile: bottom sheet, no overlay --}}
<div x-data="{ show: true }" x-show="show" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-y-full"
     x-transition:enter-end="translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-y-0"
     x-transition:leave-end="translate-y-full"
     class="fixed bottom-0 left-0 right-0 z-[9999] lg:hidden"
     style="padding-bottom: env(safe-area-inset-bottom, 0px);">

    <div class="bg-white rounded-t-2xl w-full overflow-hidden"
         style="box-shadow: 0 -8px 30px rgba(0,0,0,0.15); border-top: 1px solid #E5E7EB;">

        {{-- Drag handle --}}
        <div class="flex justify-center pt-2.5 pb-1">
            <div class="w-10 h-1 rounded-full" style="background: #D1D5DB;"></div>
        </div>

        <div class="px-4 pb-4 pt-1">
            {{-- Header: icon + title + step + skip --}}
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: {{ $current['badge_bg'] }};">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $current['icon'] !!}</svg>
                    </div>
                    <div>
                        <span class="font-semibold text-[13px] block leading-tight" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ $current['title'] }}</span>
                        <span class="text-[10px]" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">{{ $current['step_label'] }}</span>
                    </div>
                </div>
                <a href="{{ $dismissUrl }}" class="text-xs px-2 py-1 rounded-full" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                    Passer ✕
                </a>
            </div>

            {{-- Description --}}
            <p class="text-xs leading-relaxed mb-3" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $current['description'] }}</p>

            {{-- Progress dots + button --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-1.5">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="rounded-full {{ $i === $tourStep ? 'w-2 h-2' : 'w-1.5 h-1.5' }}" style="background: {{ $i === $tourStep ? '#42B574' : ($i < $tourStep ? '#42B574' : '#D1D5DB') }}; {{ $i < $tourStep ? 'opacity: 0.5;' : '' }}"></div>
                    @endfor
                </div>

                <a href="{{ $current['next_url'] }}" class="py-2.5 px-5 rounded-xl text-white font-medium text-sm text-center transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: {{ $current['badge_bg'] }};">
                    @if($current['is_last'] ?? false)
                        {{ $current['next_label'] }}
                    @else
                        Suivant →
                    @endif
                </a>
            </div>
        </div>

        {{-- Extra safe area spacer for phones with gesture bar --}}
        <div style="height: env(safe-area-inset-bottom, 8px); min-height: 8px; background: white;"></div>
    </div>
</div>
