{{-- SVG Transitions between header and content --}}
{{-- Expects: $transition, optional $fillColor (default white) --}}
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? 'white';
    $fillAlpha = [
        '70' => str_replace('white', 'rgba(255,255,255,0.7)', $fillColor === 'white' ? 'white' : $fillColor . 'B3'),
        '50' => str_replace('white', 'rgba(255,255,255,0.5)', $fillColor === 'white' ? 'white' : $fillColor . '80'),
        '30' => str_replace('white', 'rgba(255,255,255,0.3)', $fillColor === 'white' ? 'white' : $fillColor . '4D'),
    ];
    // For non-white fills, use rgba with opacity
    if ($fillColor !== 'white') {
        $hex = ltrim($fillColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $fillAlpha['70'] = "rgba($r,$g,$b,0.7)";
        $fillAlpha['50'] = "rgba($r,$g,$b,0.5)";
        $fillAlpha['30'] = "rgba($r,$g,$b,0.3)";
    } else {
        $fillAlpha['70'] = 'rgba(255,255,255,0.7)';
        $fillAlpha['50'] = 'rgba(255,255,255,0.5)';
        $fillAlpha['30'] = 'rgba(255,255,255,0.3)';
    }
@endphp

@if($transition === 'wave')
    <div class="waves-container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="{{ $fillAlpha['70'] }}" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="{{ $fillAlpha['30'] }}" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>

@elseif($transition === 'double_wave')
    <div class="waves-container" style="height: 70px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave-dbl" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave-dbl" x="48" y="0" fill="{{ $fillAlpha['70'] }}" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="2" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="4" fill="{{ $fillAlpha['30'] }}" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="6" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>

@elseif($transition === 'arch')
    <svg viewBox="0 0 400 60" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,0 Q200,120 400,0 L400,60 L0,60 Z" fill="{{ $fillColor }}" />
    </svg>

@elseif($transition === 'diagonal')
    <svg viewBox="0 0 400 40" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 400,30 400,40 0,40" fill="{{ $fillColor }}" />
    </svg>

@elseif($transition === 'chevron')
    <svg viewBox="0 0 400 30" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 200,30 400,0 400,30 0,30" fill="{{ $fillColor }}" />
    </svg>

@endif
{{-- 'none' = rien affiché --}}
