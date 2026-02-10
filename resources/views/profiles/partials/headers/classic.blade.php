{{-- Header: Classic (#1) - Dégradé plein + wave animée --}}
<div class="relative" style="background: linear-gradient(180deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-12 pb-2 text-center">
        @include('profiles.partials.photo', ['photoStyle' => 'round_center'])
        @include('profiles.partials.info')
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'wave'])
</div>
