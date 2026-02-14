{{-- Header: Duo (#6) - Photo à gauche, infos à droite --}}
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
    @include('profiles.partials.share-button')
    <div class="flex relative" style="z-index: 1;">
        {{-- Left: Photo (slightly darker overlay) --}}
        <div class="w-[38%] flex items-center justify-center py-12" style="background: rgba(0,0,0,0.12);">
            @if($profile->photo_path)
                <img src="{{ Storage::url($profile->photo_path) }}"
                     class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-xl">
            @else
                <div class="w-24 h-24 rounded-full bg-white/20 border-4 border-white/80 shadow-xl flex items-center justify-center">
                    <span class="text-4xl">👤</span>
                </div>
            @endif
        </div>
        {{-- Right: Info (slightly lighter) --}}
        <div class="w-[62%] flex flex-col justify-center py-12 px-5" style="background: rgba(255,255,255,0.06);">
            <h1 class="text-xl font-semibold" style="letter-spacing: -0.02em; color: {{ $headerTextColor }};">{{ $profile->full_name }}</h1>
            @if($profile->job_title)
                <p class="text-sm font-medium mt-1" style="opacity: 0.9; color: {{ $headerTextColor }};">{{ $profile->job_title }}</p>
            @endif
            @if($profile->company || $profile->location)
                <p class="text-xs mt-1" style="opacity: 0.8; color: {{ $headerTextColor }};">
                    {{ $profile->company }}@if($profile->company && $profile->location) · @endif{{ $profile->location }}
                </p>
            @endif
            @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="text-xs mt-3 hover:underline" style="opacity: 0.85; color: {{ $headerTextColor }};">{{ $profile->formatted_phone }}</a>
            @endif
            @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="text-xs mt-0.5 hover:underline" style="opacity: 0.85; color: {{ $headerTextColor }};">{{ $profile->email }}</a>
            @endif
        </div>
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'wave'])
</div>
