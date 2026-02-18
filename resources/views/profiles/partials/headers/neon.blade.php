{{-- Header: Néon (#14) - Fond sombre, effet lumineux néon --}}
<style>
    @keyframes neon-float {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.4; }
        50% { transform: translateY(-15px) scale(1.3); opacity: 0.8; }
    }
    @keyframes neon-pulse {
        0%, 100% { opacity: 0.3; box-shadow: 0 0 4px currentColor; }
        50% { opacity: 0.7; box-shadow: 0 0 12px currentColor; }
    }
    @keyframes neon-drift {
        0% { transform: translateX(-8px) translateY(0); }
        33% { transform: translateX(8px) translateY(-5px); }
        66% { transform: translateX(-4px) translateY(3px); }
        100% { transform: translateX(-8px) translateY(0); }
    }
    .neon-particle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
</style>
<div style="background: linear-gradient(160deg, #0A0A18 0%, {{ $primaryColor }}30 40%, {{ $secondaryColor }}50 70%, #0F0F1A 100%);">
    <div class="relative overflow-hidden">
        {{-- Glow ambiance: large blurred circle behind photo area --}}
        <div class="absolute" style="width: 200px; height: 200px; top: 20%; left: 50%; transform: translateX(-50%); background: radial-gradient(circle, {{ $primaryColor }}25 0%, transparent 70%); filter: blur(40px);"></div>

        {{-- Neon particles --}}
        <div class="neon-particle" style="width: 5px; height: 5px; background: {{ $primaryColor }}; color: {{ $primaryColor }}; top: 12%; left: 8%; animation: neon-pulse 3s ease-in-out infinite;"></div>
        <div class="neon-particle" style="width: 3px; height: 3px; background: {{ $primaryColor }}; color: {{ $primaryColor }}; top: 25%; right: 12%; animation: neon-float 5s ease-in-out infinite 0.5s;"></div>
        <div class="neon-particle" style="width: 6px; height: 6px; background: {{ $primaryColor }}40; top: 55%; left: 18%; animation: neon-drift 8s ease-in-out infinite;"></div>
        <div class="neon-particle" style="width: 4px; height: 4px; background: {{ $secondaryColor }}; color: {{ $secondaryColor }}; top: 35%; right: 25%; animation: neon-pulse 4s ease-in-out infinite 1s;"></div>
        <div class="neon-particle" style="width: 7px; height: 7px; background: {{ $primaryColor }}30; top: 65%; right: 10%; animation: neon-float 6s ease-in-out infinite 2s;"></div>
        <div class="neon-particle" style="width: 2px; height: 2px; background: white; top: 18%; left: 35%; animation: neon-float 4s ease-in-out infinite 1.5s;"></div>
        <div class="neon-particle" style="width: 4px; height: 4px; background: {{ $primaryColor }}50; top: 75%; left: 65%; animation: neon-drift 7s ease-in-out infinite 3s;"></div>

        {{-- Subtle top line glow --}}
        <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, {{ $primaryColor }}60, transparent);"></div>

        @include('profiles.partials.share-button')
        <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
            @include('profiles.partials.photo', [
                'photoStyle' => $templateConfig['photo_style'] ?? 'round_center',
                'borderColor' => $primaryColor,
                'extraStyle' => "box-shadow: 0 0 15px {$primaryColor}60, 0 0 30px {$primaryColor}30, 0 0 0 3px {$primaryColor}40;",
            ])
            @include('profiles.partials.info', ['headerTextColor' => '#FFFFFF'])
        </div>
    </div>
</div>
