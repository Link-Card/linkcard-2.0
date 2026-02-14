{{-- Header: Banner (#7) - Bannière + photo débordante --}}
<div class="relative">
    @include('profiles.partials.share-button')
    {{-- Short gradient banner --}}
    <div style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
        <div style="height: 120px;"></div>
        @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'none'])
    </div>
    {{-- Photo overlaps + info on white --}}
    <div class="bg-white text-center pb-4">
        @include('profiles.partials.photo', ['photoStyle' => $templateConfig['photo_style'] ?? 'round_overlap'])
        <div class="mt-3 px-6">
            @include('profiles.partials.info', ['headerTextColor' => '#2C2A27'])
        </div>
    </div>
</div>
