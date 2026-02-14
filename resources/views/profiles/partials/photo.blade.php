{{-- Photo component - supports: round_center, round_left, round_overlap, square_center --}}
{{-- Optional params: $borderColor (default white), $extraStyle (inline CSS), $noBg (for bold/dark headers) --}}
@php
    $photoStyle = $photoStyle ?? 'round_center';
    $borderColor = $borderColor ?? 'white';
    $extraStyle = $extraStyle ?? '';
    $noBg = $noBg ?? false;
    
    $shape = match($photoStyle) {
        'square_center' => 'rounded-2xl',
        default => 'rounded-full',
    };
    $margin = $photoStyle === 'round_overlap' ? 'margin-top: -56px;' : '';
    $wrapClass = $photoStyle === 'round_overlap' ? 'flex justify-center' : 'flex justify-center mb-5';
    $borderClass = $borderColor === 'white' ? 'border-4 border-white' : 'border-[3px]';
    $borderStyle = $borderColor !== 'white' ? "border-color: {$borderColor};" : '';
    $placeholderBg = $noBg 
        ? "background: linear-gradient(135deg, {$primaryColor}, {$secondaryColor});" 
        : ($photoStyle === 'round_overlap' 
            ? "background: linear-gradient(135deg, {$primaryColor}, {$secondaryColor});" 
            : 'background: rgba(255,255,255,0.3);');
@endphp

<div class="{{ $wrapClass }}">
    @if($profile->photo_path)
        <img src="{{ Storage::url($profile->photo_path) }}"
             class="w-28 h-28 {{ $shape }} object-cover {{ $borderClass }} shadow-xl"
             style="{{ $borderStyle }} {{ $margin }} {{ $extraStyle }}">
    @else
        <div class="w-28 h-28 {{ $shape }} {{ $borderClass }} shadow-xl flex items-center justify-center"
             style="{{ $placeholderBg }} {{ $borderStyle }} {{ $margin }} {{ $extraStyle }}">
            <span class="text-5xl">👤</span>
        </div>
    @endif
</div>
