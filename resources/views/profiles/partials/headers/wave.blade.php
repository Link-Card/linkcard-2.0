{{-- Header: Vague v1 (#2) - Double wave comme Link-Card v1 --}}
<div class="relative" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-12 pb-2 text-center">
        @include('profiles.partials.photo', ['photoStyle' => 'round_center'])
        @include('profiles.partials.info')
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'double_wave'])
</div>
