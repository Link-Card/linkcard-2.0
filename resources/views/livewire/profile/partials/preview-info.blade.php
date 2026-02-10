{{-- Preview info - used in preview.blade.php --}}
@php $textColor = $textColor ?? '#FFFFFF'; @endphp

<h2 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: {{ $textColor }};">{{ $full_name ?: 'Votre nom' }}</h2>

@if($job_title)
    <p class="text-base font-medium mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.9; color: {{ $textColor }};">{{ $job_title }}</p>
@endif

@if($company || $location)
    <p class="text-sm mt-1" style="font-family: 'Manrope', sans-serif; opacity: 0.8; color: {{ $textColor }};">
        {{ $company }}@if($company && $location) · @endif{{ $location }}
    </p>
@endif

@if($phone || $email)
    <div class="mt-3 space-y-0.5">
        @if($phone)
            @php
                $digits = preg_replace('/\D/', '', $phone);
                $fmtPhone = strlen($digits) === 10 ? substr($digits,0,3).'-'.substr($digits,3,3).'-'.substr($digits,6) : $phone;
            @endphp
            <p class="text-sm" style="opacity: 0.85; color: {{ $textColor }};">{{ $fmtPhone }}</p>
        @endif
        @if($email)<p class="text-sm" style="opacity: 0.85; color: {{ $textColor }};">{{ $email }}</p>@endif
    </div>
@endif
