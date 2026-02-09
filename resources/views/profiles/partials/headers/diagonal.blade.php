{{-- Header: Diagonal (#4) - Coupe en angle --}}
<div class="relative" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    <div class="px-6 pt-12 pb-14 text-center">
        @include('profiles.partials.photo', ['photoStyle' => 'round_center'])
        @include('profiles.partials.info')
    </div>
</div>
@include('profiles.partials.transition', ['transition' => 'diagonal'])
