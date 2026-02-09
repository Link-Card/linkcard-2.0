{{-- Header: Bold (#9) - Fond sombre + accent couleur --}}
<div class="relative" style="background: #2C2A27;">
    @include('profiles.partials.share-button')
    
    {{-- Gradient accent line at bottom --}}
    <div class="absolute bottom-0 left-0 right-0" style="height: 4px; background: linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }});"></div>
    
    <div class="px-6 pt-12 pb-8 text-center">
        {{-- Photo with gradient border --}}
        <div class="flex justify-center mb-5">
            @if($profile->photo_path)
                <img src="{{ Storage::url($profile->photo_path) }}"
                     class="w-28 h-28 rounded-full object-cover shadow-xl"
                     style="border: 3px solid {{ $primaryColor }};">
            @else
                <div class="w-28 h-28 rounded-full shadow-xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }}); border: 3px solid {{ $primaryColor }};">
                    <span class="text-5xl">👤</span>
                </div>
            @endif
        </div>
        @include('profiles.partials.info', ['headerTextColor' => '#FFFFFF'])
    </div>
</div>
{{-- Pas de transition SVG (coupe nette = volontaire pour le style Bold) --}}
