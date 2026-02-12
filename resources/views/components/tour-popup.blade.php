@php
    $tourStep = (int) request()->query('tour', 0);
    if ($tourStep < 1 || $tourStep > 4) return;

    $user = auth()->user();
    $profile = $user?->profiles()->first();

    $steps = [
        1 => [
            'title' => 'Éditeur de profil',
            'description' => 'Personnalisez votre carte Link-Card ici.',
            'badge_bg' => '#42B574',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>',
            'next_url' => route('stats.index', ['tour' => 2]),
            'next_label' => 'Statistiques',
            'step_label' => '1/4',
            'icon_bg' => '#F0F9F4',
            'icon_border' => '#D1FAE5',
        ],
        2 => [
            'title' => 'Statistiques',
            'description' => 'Suivez vos visites et clics.',
            'badge_bg' => '#E11D48',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
            'next_url' => route('cards.index', ['tour' => 3]),
            'next_label' => 'Cartes NFC',
            'step_label' => '2/4',
            'icon_bg' => '#FFF1F2',
            'icon_border' => '#FECDD3',
        ],
        3 => [
            'title' => 'Cartes NFC',
            'description' => 'Partagez votre profil d\'un geste.',
            'badge_bg' => '#4A7FBF',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>',
            'next_url' => route('subscription.plans', ['tour' => 4]),
            'next_label' => 'Forfaits',
            'step_label' => '3/4',
            'icon_bg' => '#EFF6FF',
            'icon_border' => '#BFDBFE',
        ],
        4 => [
            'title' => 'Forfaits',
            'description' => 'Pro et Premium pour plus de fonctionnalités.',
            'badge_bg' => '#8B5CF6',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>',
            'next_url' => route('subscription.plans'),
            'next_label' => 'Terminer',
            'step_label' => '4/4',
            'is_last' => true,
            'icon_bg' => '#F3F0FF',
            'icon_border' => '#DDD6FE',
        ],
    ];

    $current = $steps[$tourStep] ?? null;
    if (!$current) return;

    $dismissUrl = route('dashboard');
@endphp

{{-- ═══════════════════════════════ --}}
{{-- DESKTOP: centered popup --}}
{{-- ═══════════════════════════════ --}}
<div x-data="{ show: true, confirm: false }" x-show="show" x-cloak
     class="fixed inset-0 z-[9999] hidden lg:flex items-center justify-center p-4"
     style="background: rgba(0,0,0,0.25); backdrop-filter: blur(1px);">

    {{-- Tour popup --}}
    <div x-show="!confirm" class="bg-white rounded-2xl w-full max-w-sm overflow-hidden relative"
         style="box-shadow: 0 25px 50px rgba(0,0,0,0.15);">

        @if($current['step_label'])
        <div class="absolute top-4 left-5">
            <span class="text-xs font-medium px-2.5 py-1 rounded-full" style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;">{{ $current['step_label'] }}</span>
        </div>
        @endif

        <button @click="confirm = true" class="absolute top-4 right-4 text-xs px-2.5 py-1 rounded-full transition-colors" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
            Passer ✕
        </button>

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
                    <div class="rounded-full {{ $i === $tourStep ? 'w-2.5 h-2.5' : 'w-2 h-2' }}" style="background: {{ $i === $tourStep ? '#42B574' : ($i < $tourStep ? '#42B574' : '#D1D5DB') }};"></div>
                @endfor
            </div>
            <a href="{{ $current['next_url'] }}" class="block w-full py-3 px-6 rounded-xl text-white font-medium text-sm text-center" style="font-family: 'Manrope', sans-serif; background: {{ $current['badge_bg'] }};">
                @if($current['is_last'] ?? false) {{ $current['next_label'] }} @else Suivant : {{ $current['next_label'] }} → @endif
            </a>
        </div>
    </div>

    {{-- Confirm skip (desktop) --}}
    <div x-show="confirm" x-cloak class="bg-white rounded-2xl max-w-sm w-full p-6" style="box-shadow: 0 20px 48px rgba(0,0,0,0.2);">
        <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4" style="background: #FEF3C7;">
            <svg class="w-7 h-7" fill="#F59E0B" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-center mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Passer le tour?</h3>
        <p class="text-sm text-center mb-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Vous pourrez toujours explorer les pages par vous-même depuis le menu.</p>
        <div class="flex space-x-3">
            <button @click="confirm = false" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; background: #F3F4F6; color: #4B5563;">Continuer le tour</button>
            <a href="{{ $dismissUrl }}" class="flex-1 py-2.5 px-4 rounded-lg text-sm font-medium text-white text-center transition-colors" style="font-family: 'Manrope', sans-serif; background: #F59E0B;">Passer</a>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════ --}}
{{-- MOBILE: compact floating bar --}}
{{-- ═══════════════════════════════ --}}
<div x-data="{ confirm: false }" class="lg:hidden">

    {{-- Tour bar --}}
    <div x-show="!confirm"
         style="position: fixed; bottom: 16px; left: 8px; right: 8px; z-index: 9999; box-shadow: 0 2px 12px rgba(0,0,0,0.12); border: 1px solid #E5E7EB; border-radius: 14px; background: white; overflow: hidden;">
        <div style="padding: 10px 12px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: {{ $current['badge_bg'] }};">
                    <svg style="width: 16px; height: 16px; color: white;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $current['icon'] !!}</svg>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-family: 'Manrope', sans-serif; font-size: 12px; font-weight: 600; color: #2C2A27; line-height: 1.2;">{{ $current['title'] }} <span style="color: #9CA3AF; font-weight: 400;">{{ $current['step_label'] }}</span></div>
                    <div style="font-family: 'Manrope', sans-serif; font-size: 11px; color: #4B5563; line-height: 1.3; margin-top: 1px;">{{ $current['description'] }}</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <button @click="confirm = true" style="font-family: 'Manrope', sans-serif; font-size: 11px; color: #9CA3AF; background: none; border: none; padding: 4px 0; cursor: pointer;">Passer</button>
                    <div style="display: flex; gap: 4px; margin-left: 4px;">
                        @for($i = 1; $i <= 4; $i++)
                            <div style="width: {{ $i === $tourStep ? '6px' : '5px' }}; height: {{ $i === $tourStep ? '6px' : '5px' }}; border-radius: 50%; background: {{ $i === $tourStep ? '#42B574' : ($i < $tourStep ? '#42B574' : '#D1D5DB') }};"></div>
                        @endfor
                    </div>
                </div>
                <a href="{{ $current['next_url'] }}" style="font-family: 'Manrope', sans-serif; font-size: 12px; font-weight: 500; color: white; background: {{ $current['badge_bg'] }}; padding: 7px 14px; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                    @if($current['is_last'] ?? false) {{ $current['next_label'] }} @else Suivant → @endif
                </a>
            </div>
        </div>
    </div>

    {{-- Confirm skip (mobile) --}}
    <div x-show="confirm" x-cloak
         style="position: fixed; inset: 0; z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 16px; background: rgba(0,0,0,0.5);">
        <div style="background: white; border-radius: 16px; max-width: 300px; width: 100%; padding: 20px; box-shadow: 0 20px 48px rgba(0,0,0,0.2);">
            <div style="width: 48px; height: 48px; margin: 0 auto 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #FEF3C7;">
                <svg style="width: 24px; height: 24px;" fill="#F59E0B" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
            </div>
            <h3 style="font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 600; color: #2C2A27; text-align: center; margin-bottom: 6px;">Passer le tour?</h3>
            <p style="font-family: 'Manrope', sans-serif; font-size: 12px; color: #4B5563; text-align: center; margin-bottom: 16px;">Vous pourrez explorer par vous-même depuis le menu.</p>
            <div style="display: flex; gap: 8px;">
                <button @click="confirm = false" style="flex: 1; font-family: 'Manrope', sans-serif; font-size: 13px; font-weight: 500; padding: 10px; border-radius: 10px; border: none; cursor: pointer; background: #F3F4F6; color: #4B5563;">Continuer</button>
                <a href="{{ $dismissUrl }}" style="flex: 1; font-family: 'Manrope', sans-serif; font-size: 13px; font-weight: 500; padding: 10px; border-radius: 10px; text-decoration: none; text-align: center; background: #F59E0B; color: white;">Passer</a>
            </div>
        </div>
    </div>
</div>
