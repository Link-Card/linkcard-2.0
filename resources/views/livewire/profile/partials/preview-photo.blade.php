{{-- Preview photo - used in preview.blade.php --}}
@php
    $photoStyle = $photoStyle ?? 'round_center';
    $borderStyle = $borderStyle ?? 'border: 4px solid white;';
    $shadowColor = $shadowColor ?? null;
    $boxShadow = $shadowColor ? "box-shadow: 0 4px 16px {$shadowColor}40;" : '';
    $overlapContext = $overlapContext ?? false;
    
    $shape = ($photoStyle === 'square_center') ? 'rounded-2xl' : 'rounded-full';
    $isOverlap = ($photoStyle === 'round_overlap');
    
    // Overlap accent ring when not in banner context
    if ($isOverlap && !$overlapContext) {
        $borderStyle = "border: 3px solid rgba(255,255,255,0.9);";
        $boxShadow = "box-shadow: 0 0 0 3px {$primary_color}40, 0 8px 16px rgba(0,0,0,0.15);";
    }
    
    $marginStyle = ($isOverlap && $overlapContext) ? 'margin-top: -48px;' : '';
    $mbClass = ($isOverlap && $overlapContext) ? '' : 'mb-4';
@endphp

@if($profile->photo_path)
    <img src="{{ Storage::url($profile->photo_path) }}" class="w-24 h-24 {{ $shape }} object-cover shadow-xl mx-auto {{ $mbClass }}" style="{{ $borderStyle }} {{ $boxShadow }} {{ $marginStyle }}">
@else
    <div class="w-24 h-24 {{ $shape }} bg-white/30 shadow-xl mx-auto {{ $mbClass }} flex items-center justify-center" style="{{ $borderStyle }} {{ $boxShadow }} {{ $marginStyle }}">
        <span class="text-4xl">👤</span>
    </div>
@endif
