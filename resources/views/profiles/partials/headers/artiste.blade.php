{{-- Header: Artiste (#11) - Abstrait créatif avec formes organiques --}}
<style>
    @keyframes morph {
        0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    }
    @keyframes rotate-slow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="relative" style="background: linear-gradient(160deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%); overflow: hidden;">
    {{-- Blob 1 --}}
    <div style="position: absolute; top: -40px; right: -30px; width: 160px; height: 160px; background: rgba(255,255,255,0.08); animation: morph 8s ease-in-out infinite;"></div>
    {{-- Blob 2 --}}
    <div style="position: absolute; bottom: 20px; left: -40px; width: 120px; height: 120px; background: rgba(255,255,255,0.06); animation: morph 10s ease-in-out infinite 2s;"></div>
    {{-- Ligne décorative rotative --}}
    <div style="position: absolute; top: 50%; left: 50%; width: 200px; height: 200px; border: 1px solid rgba(255,255,255,0.05); border-radius: 50%; transform: translate(-50%, -50%); animation: rotate-slow 30s linear infinite;"></div>
    <div style="position: absolute; top: 50%; left: 50%; width: 260px; height: 260px; border: 1px solid rgba(255,255,255,0.03); border-radius: 50%; transform: translate(-50%, -50%); animation: rotate-slow 45s linear infinite reverse;"></div>

    @include('profiles.partials.share-button')
    <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
        @include('profiles.partials.photo', ['photoStyle' => $templateConfig['photo_style'] ?? 'round_center'])
        @include('profiles.partials.info')
    </div>

    @if(isset($templateTransition) && $templateTransition !== 'none')
        @include('profiles.partials.transition', ['transition' => $templateTransition, 'fillColor' => $bodyBg ?? '#FFFFFF'])
    @endif
</div>
