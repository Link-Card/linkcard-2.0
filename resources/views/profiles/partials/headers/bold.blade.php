{{-- Header: Bold (#9) - Fond sombre + accent couleur --}}
<div class="relative" style="background: #2C2A27;">
    @include('profiles.partials.share-button')
    
    {{-- Gradient accent line at bottom (only when no transition) --}}
    @if(($templateTransition ?? 'none') === 'none')
        <div class="absolute bottom-0 left-0 right-0" style="height: 4px; background: linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }}); z-index: 2;"></div>
    @endif
    
    <div class="px-6 pt-12 pb-8 text-center">
        @include('profiles.partials.photo', [
            'photoStyle' => $templateConfig['photo_style'] ?? 'round_center',
            'borderColor' => $primaryColor,
            'noBg' => true,
        ])
        @include('profiles.partials.info', ['headerTextColor' => '#FFFFFF'])
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'none', 'fillColor' => '#E8E6E3'])
</div>
