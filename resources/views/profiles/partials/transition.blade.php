{{-- SVG Transitions between header and content --}}
{{-- Expects: $transition, $fillColor (body bg), optional $gradientColor (header bottom color) --}}
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? 'white';
    $gradientColor = $gradientColor ?? null;

    // Compute rgba variants of fillColor for semi-transparent wave layers
    if ($fillColor !== 'white' && $fillColor !== '#FFFFFF') {
        $hex = ltrim($fillColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $fillAlpha = [
            '70' => "rgba($r,$g,$b,0.7)",
            '50' => "rgba($r,$g,$b,0.5)",
            '30' => "rgba($r,$g,$b,0.3)",
        ];
    } else {
        $fillAlpha = [
            '70' => 'rgba(255,255,255,0.7)',
            '50' => 'rgba(255,255,255,0.5)',
            '30' => 'rgba(255,255,255,0.3)',
        ];
    }

    // Background for the transition container = header's bottom color
    // This ensures transparent wave areas show the gradient color, not white
    $containerBg = $gradientColor ?? ($fillColor === 'white' ? '#FFFFFF' : $fillColor);
@endphp

@if($transition === 'wave')
    <div class="waves-container" style="margin-bottom: -2px; background: {{ $containerBg }};">
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
    <div class="waves-container" style="height: 70px; margin-bottom: -2px; background: {{ $containerBg }};">
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
    <div style="margin-bottom: -2px; line-height: 0; background: {{ $containerBg }};">
        <svg viewBox="0 0 400 60" style="display: block; width: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,120 400,0 L400,60 L0,60 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'diagonal')
    <div style="margin-bottom: -2px; line-height: 0; background: {{ $containerBg }};">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,30 400,40 0,40" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'chevron')
    <div style="margin-bottom: -2px; line-height: 0; background: {{ $containerBg }};">
        <svg viewBox="0 0 400 30" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,30 400,0 400,30 0,30" fill="{{ $fillColor }}" />
        </svg>
    </div>

@endif
{{-- 'none' = rien affiché --}}
