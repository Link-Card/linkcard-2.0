{{-- Header: Géométrique (#8) - Formes abstraites + chevron --}}
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    
    {{-- Decorative shapes --}}
    <div class="absolute" style="top: 10px; left: -20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
    <div class="absolute" style="top: -20px; right: 30px; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,0.05);"></div>
    <div class="absolute" style="bottom: 30px; right: -10px; width: 70px; height: 70px; background: rgba(255,255,255,0.04); transform: rotate(45deg);"></div>
    <div class="absolute" style="bottom: 60px; left: 20px; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.03);"></div>
    
    <div class="relative z-10 px-6 pt-12 pb-10 text-center">
        @include('profiles.partials.photo', ['photoStyle' => 'square_center'])
        @include('profiles.partials.info')
    </div>
</div>
@include('profiles.partials.transition', ['transition' => 'chevron'])
