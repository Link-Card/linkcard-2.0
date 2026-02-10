{{-- Header: Arche (#5) - Courbe élégante avec effet radial --}}
<div class="relative overflow-hidden" style="background: linear-gradient(160deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 60%, {{ $primaryColor }}88 100%);">
    {{-- Cercles décoratifs subtils --}}
    <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.06);"></div>
    <div style="position: absolute; bottom: 40px; left: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
    @include('profiles.partials.share-button')
    <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
        @include('profiles.partials.photo', ['photoStyle' => 'round_center'])
        @include('profiles.partials.info')
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'arch'])
</div>
