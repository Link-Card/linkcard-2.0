{{-- Profile info block - reused in all headers --}}
{{-- Expects: $profile, $headerTextColor, $showCompact (optional) --}}
@php $showCompact = $showCompact ?? false; @endphp

<h1 class="text-2xl font-semibold" style="letter-spacing: -0.02em; color: {{ $headerTextColor }};">{{ $profile->full_name }}</h1>

@if($profile->job_title)
    <p class="text-base font-medium mt-1" style="opacity: 0.9; color: {{ $headerTextColor }};">{{ $profile->job_title }}</p>
@endif

@if($profile->company || $profile->location)
    <p class="text-sm mt-1" style="opacity: 0.8; color: {{ $headerTextColor }};">
        {{ $profile->company }}@if($profile->company && $profile->location) · @endif{{ $profile->location }}
    </p>
@endif

@unless($showCompact)
    @if($profile->phone || $profile->email)
        <div class="mt-4 space-y-1">
            @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="block text-sm hover:underline" style="opacity: 0.85; color: {{ $headerTextColor }};">
                    {{ $profile->formatted_phone }}
                </a>
            @endif
            @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="block text-sm hover:underline" style="opacity: 0.85; color: {{ $headerTextColor }};">
                    {{ $profile->email }}
                </a>
            @endif
        </div>
    @endif
@endunless
