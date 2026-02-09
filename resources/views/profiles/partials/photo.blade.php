{{-- Photo component - supports: round_center, round_left, round_overlap, square_center --}}
@php $photoStyle = $photoStyle ?? 'round_center'; @endphp

@if($photoStyle === 'square_center')
    {{-- Square rounded --}}
    <div class="flex justify-center mb-5">
        @if($profile->photo_path)
            <img src="{{ Storage::url($profile->photo_path) }}"
                 class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-xl">
        @else
            <div class="w-28 h-28 rounded-2xl bg-white/30 border-4 border-white shadow-xl flex items-center justify-center">
                <span class="text-5xl">👤</span>
            </div>
        @endif
    </div>
@elseif($photoStyle === 'round_overlap')
    {{-- Round overlapping (rendered separately in banner header) --}}
    <div class="flex justify-center">
        @if($profile->photo_path)
            <img src="{{ Storage::url($profile->photo_path) }}"
                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl" style="margin-top: -56px;">
        @else
            <div class="w-28 h-28 rounded-full bg-white/30 border-4 border-white shadow-xl flex items-center justify-center" style="margin-top: -56px; background: linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }});">
                <span class="text-5xl">👤</span>
            </div>
        @endif
    </div>
@else
    {{-- Default: round_center (also used for round_left but positioned differently by parent) --}}
    <div class="flex justify-center mb-5">
        @if($profile->photo_path)
            <img src="{{ Storage::url($profile->photo_path) }}"
                 class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl">
        @else
            <div class="w-28 h-28 rounded-full bg-white/30 border-4 border-white shadow-xl flex items-center justify-center">
                <span class="text-5xl">👤</span>
            </div>
        @endif
    </div>
@endif
