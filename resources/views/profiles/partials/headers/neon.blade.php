{{-- Header: Néon (#14) - Fond sombre, effet lumineux néon --}}
<style>
    @keyframes neon-float {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
        50% { transform: translateY(-18px) scale(1.4); opacity: 1; }
    }
    @keyframes neon-pulse {
        0%, 100% { opacity: 0.4; box-shadow: 0 0 6px currentColor; }
        50% { opacity: 0.9; box-shadow: 0 0 18px currentColor; }
    }
    @keyframes neon-drift {
        0% { transform: translateX(-12px) translateY(0); opacity: 0.3; }
        33% { transform: translateX(12px) translateY(-8px); opacity: 0.6; }
        66% { transform: translateX(-6px) translateY(4px); opacity: 0.4; }
        100% { transform: translateX(-12px) translateY(0); opacity: 0.3; }
    }
    @keyframes neon-glow-breathe {
        0%, 100% { opacity: 0.15; transform: translateX(-50%) scale(1); }
        50% { opacity: 0.3; transform: translateX(-50%) scale(1.1); }
    }
    .neon-particle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }
</style>
<div style="background: linear-gradient(160deg, #0A0A18 0%, {{ $primaryColor }}25 35%, {{ $secondaryColor }}40 65%, #0F0F1A 100%);">
    <div class="relative overflow-hidden">
        {{-- Main glow ambiance: large blurred circle behind photo --}}
        <div class="absolute" style="width: 280px; height: 280px; top: 15%; left: 50%; transform: translateX(-50%); background: radial-gradient(circle, {{ $primaryColor }}35 0%, {{ $primaryColor }}15 40%, transparent 70%); filter: blur(50px); animation: neon-glow-breathe 4s ease-in-out infinite;"></div>

        {{-- Secondary glow --}}
        <div class="absolute" style="width: 150px; height: 150px; top: 60%; left: 20%; background: radial-gradient(circle, {{ $secondaryColor }}20 0%, transparent 70%); filter: blur(35px);"></div>
        <div class="absolute" style="width: 120px; height: 120px; top: 30%; right: 10%; background: radial-gradient(circle, {{ $primaryColor }}15 0%, transparent 70%); filter: blur(30px);"></div>

        {{-- Neon particles - more visible --}}
        <div class="neon-particle" style="width: 6px; height: 6px; background: {{ $primaryColor }}; color: {{ $primaryColor }}; top: 10%; left: 8%; animation: neon-pulse 3s ease-in-out infinite;"></div>
        <div class="neon-particle" style="width: 4px; height: 4px; background: {{ $primaryColor }}; color: {{ $primaryColor }}; top: 22%; right: 12%; animation: neon-float 4.5s ease-in-out infinite 0.5s;"></div>
        <div class="neon-particle" style="width: 8px; height: 8px; background: {{ $primaryColor }}50; color: {{ $primaryColor }}; top: 50%; left: 15%; animation: neon-pulse 5s ease-in-out infinite 1s;"></div>
        <div class="neon-particle" style="width: 5px; height: 5px; background: {{ $secondaryColor }}; color: {{ $secondaryColor }}; top: 32%; right: 22%; animation: neon-pulse 3.5s ease-in-out infinite 0.8s;"></div>
        <div class="neon-particle" style="width: 9px; height: 9px; background: {{ $primaryColor }}40; top: 68%; right: 8%; animation: neon-float 6s ease-in-out infinite 2s;"></div>
        <div class="neon-particle" style="width: 3px; height: 3px; background: white; top: 15%; left: 32%; animation: neon-float 3.5s ease-in-out infinite 1.2s;"></div>
        <div class="neon-particle" style="width: 5px; height: 5px; background: {{ $primaryColor }}60; top: 78%; left: 60%; animation: neon-drift 7s ease-in-out infinite 2.5s;"></div>
        <div class="neon-particle" style="width: 3px; height: 3px; background: white; top: 45%; right: 35%; animation: neon-pulse 4s ease-in-out infinite 1.8s;"></div>
        <div class="neon-particle" style="width: 7px; height: 7px; background: {{ $secondaryColor }}30; top: 85%; left: 30%; animation: neon-drift 8s ease-in-out infinite 3s;"></div>

        {{-- Top + bottom glow lines --}}
        <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent 10%, {{ $primaryColor }}80, transparent 90%);"></div>

        @include('profiles.partials.share-button')
        <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
            @include('profiles.partials.photo', [
                'photoStyle' => $templateConfig['photo_style'] ?? 'round_center',
                'borderColor' => $primaryColor,
                'extraStyle' => "box-shadow: 0 0 20px {$primaryColor}80, 0 0 40px {$primaryColor}40, 0 0 60px {$primaryColor}20, 0 0 0 3px {$primaryColor}50;",
            ])
            @include('profiles.partials.info', ['headerTextColor' => '#FFFFFF'])
        </div>
    </div>

    @if(isset($templateTransition) && $templateTransition !== 'none')
        @include('profiles.partials.transition', ['transition' => $templateTransition, 'fillColor' => $bodyBg ?? '#FFFFFF'])
    @endif
</div>
