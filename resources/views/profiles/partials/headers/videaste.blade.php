{{-- Header: Vidéaste (#10) - Cinématique avec particules animées --}}
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, #1a1a2e 0%, {{ $primaryColor }}CC 50%, {{ $secondaryColor }} 100%);">
    {{-- Particules animées CSS --}}
    <style>
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
            50% { transform: translateY(-20px) scale(1.2); opacity: 0.7; }
        }
        @keyframes drift-horizontal {
            0% { transform: translateX(-10px); opacity: 0.2; }
            50% { transform: translateX(10px); opacity: 0.5; }
            100% { transform: translateX(-10px); opacity: 0.2; }
        }
        .particle { position: absolute; border-radius: 50%; pointer-events: none; }
    </style>
    {{-- Particules --}}
    <div class="particle" style="width: 6px; height: 6px; background: {{ $primaryColor }}; top: 15%; left: 10%; animation: float-particle 4s ease-in-out infinite;"></div>
    <div class="particle" style="width: 4px; height: 4px; background: white; top: 30%; right: 15%; animation: float-particle 5s ease-in-out infinite 1s;"></div>
    <div class="particle" style="width: 8px; height: 8px; background: {{ $primaryColor }}80; top: 60%; left: 25%; animation: float-particle 6s ease-in-out infinite 0.5s;"></div>
    <div class="particle" style="width: 5px; height: 5px; background: white; top: 20%; right: 30%; animation: drift-horizontal 7s ease-in-out infinite;"></div>
    <div class="particle" style="width: 3px; height: 3px; background: {{ $secondaryColor }}; top: 70%; right: 20%; animation: float-particle 4.5s ease-in-out infinite 2s;"></div>
    <div class="particle" style="width: 7px; height: 7px; background: {{ $primaryColor }}60; top: 45%; left: 75%; animation: drift-horizontal 5.5s ease-in-out infinite 1.5s;"></div>

    {{-- Subtle film grain overlay --}}
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,0.3) 100%);"></div>

    @include('profiles.partials.share-button')
    <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
        @include('profiles.partials.photo', ['photoStyle' => $templateConfig['photo_style'] ?? 'round_center'])
        @include('profiles.partials.info', ['headerTextColor' => '#FFFFFF'])
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'wave'])
</div>
