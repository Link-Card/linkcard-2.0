{{-- Photo component - supports: round_center, round_left, round_overlap, square_center --}}
{{-- Optional params: $borderColor, $extraStyle, $noBg, $overlapContext (for banner) --}}
@php
    $photoStyle = $photoStyle ?? 'round_center';
    $borderColor = $borderColor ?? 'white';
    $extraStyle = $extraStyle ?? '';
    $noBg = $noBg ?? false;
    $overlapContext = $overlapContext ?? false;
    
    // Shape
    $shape = ($photoStyle === 'square_center') ? 'rounded-2xl' : 'rounded-full';
    
    // Overlap: only apply negative margin in banner context
    $isOverlap = ($photoStyle === 'round_overlap');
    $margin = ($isOverlap && $overlapContext) ? 'margin-top: -56px;' : '';
    $wrapClass = ($isOverlap && $overlapContext) ? 'flex justify-center' : 'flex justify-center mb-5';
    
    // Border: custom color or white
    if ($borderColor !== 'white') {
        $borderCss = "border: 3px solid {$borderColor};";
    } elseif ($isOverlap && !$overlapContext) {
        // round_overlap outside banner: accent ring effect
        $borderCss = "border: 3px solid rgba(255,255,255,0.9); box-shadow: 0 0 0 3px {$primaryColor}40, 0 8px 24px rgba(0,0,0,0.15);";
    } else {
        $borderCss = 'border: 4px solid white;';
    }
    
    // Placeholder background
    $placeholderBg = ($noBg || $isOverlap)
        ? "background: linear-gradient(135deg, {$primaryColor}, {$secondaryColor});" 
        : 'background: rgba(255,255,255,0.3);';
@endphp

<div class="{{ $wrapClass }}">
    @if($profile->photo_path)
        <img src="{{ Storage::url($profile->photo_path) }}"
             class="w-28 h-28 {{ $shape }} object-cover shadow-xl"
             style="{{ $borderCss }} {{ $margin }} {{ $extraStyle }}">
    @else
        <div class="w-28 h-28 {{ $shape }} shadow-xl flex items-center justify-center"
             style="{{ $placeholderBg }} {{ $borderCss }} {{ $margin }} {{ $extraStyle }}">
            <span class="text-5xl">👤</span>
        </div>
    @endif
</div>
