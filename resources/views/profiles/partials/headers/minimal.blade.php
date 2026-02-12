{{-- Header: Épuré (#3) - Barre accent + fond couleur subtile --}}
<div style="height: 6px; background: linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }});"></div>
<div class="relative" style="background: linear-gradient(180deg, {{ $primaryColor }}12 0%, white 50%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-8 pb-6 text-center">
        {{-- Photo avec ombre colorée --}}
        <div class="flex justify-center mb-5">
            @if($profile->photo_path)
                <img src="{{ Storage::url($profile->photo_path) }}"
                     class="w-28 h-28 rounded-full object-cover border-4 border-white"
                     style="box-shadow: 0 4px 20px {{ $primaryColor }}40;">
            @else
                <div class="w-28 h-28 rounded-full border-4 border-white flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }}); box-shadow: 0 4px 20px {{ $primaryColor }}40;">
                    <span class="text-5xl">👤</span>
                </div>
            @endif
        </div>
        @include('profiles.partials.info', ['headerTextColor' => '#2C2A27'])
    </div>
</div>
{{-- Pas de transition (fond déjà blanc) --}}
