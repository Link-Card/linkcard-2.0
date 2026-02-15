{{-- Header: Épuré (#3) - Barre accent + fond couleur subtile --}}
<div style="height: 8px; background: linear-gradient(90deg, {{ $primaryColor }}, {{ $secondaryColor }});"></div>
<div class="relative" style="background: linear-gradient(180deg, {{ $primaryColor }}30 0%, {{ $primaryColor }}12 50%, {{ $primaryColor }}08 100%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-8 pb-6 text-center">
        @include('profiles.partials.photo', [
            'photoStyle' => $templateConfig['photo_style'] ?? 'round_center',
            'extraStyle' => 'box-shadow: 0 4px 24px ' . $primaryColor . '50;',
        ])
        @include('profiles.partials.info', ['headerTextColor' => '#2C2A27'])
    </div>
</div>
