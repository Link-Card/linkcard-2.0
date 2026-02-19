{{-- Header: Classic (#1) - Dégradé plein, finition nette --}}
<div class="relative" style="background: linear-gradient(180deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-12 pb-8 text-center">
        @include('profiles.partials.photo', ['photoStyle' => $templateConfig['photo_style'] ?? 'round_center'])
        @include('profiles.partials.info')
    </div>

    @if(isset($templateTransition) && $templateTransition !== 'none')
        @include('profiles.partials.transition', ['transition' => $templateTransition, 'fillColor' => $bodyBg ?? '#FFFFFF'])
    @endif
</div>
