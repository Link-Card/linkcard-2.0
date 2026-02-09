{{-- Preview photo - used in preview.blade.php --}}
@php
    $photoStyle = $photoStyle ?? 'round_center';
    $borderStyle = $borderStyle ?? 'border: 4px solid white;';
    $shadowColor = $shadowColor ?? null;
    $boxShadow = $shadowColor ? "box-shadow: 0 4px 16px {$shadowColor}40;" : '';
@endphp

@if($photoStyle === 'square_center')
    @if($profile->photo_path)
        <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 rounded-2xl object-cover shadow-xl mx-auto mb-4" style="{{ $borderStyle }} {{ $boxShadow }}">
    @else
        <div class="w-24 h-24 rounded-2xl bg-white/30 shadow-xl mx-auto mb-4 flex items-center justify-center" style="{{ $borderStyle }} {{ $boxShadow }}">
            <span class="text-4xl">👤</span>
        </div>
    @endif
@else
    @if($profile->photo_path)
        <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 rounded-full object-cover shadow-xl mx-auto mb-4" style="{{ $borderStyle }} {{ $boxShadow }}">
    @else
        <div class="w-24 h-24 rounded-full bg-white/30 shadow-xl mx-auto mb-4 flex items-center justify-center" style="{{ $borderStyle }} {{ $boxShadow }}">
            <span class="text-4xl">👤</span>
        </div>
    @endif
@endif
