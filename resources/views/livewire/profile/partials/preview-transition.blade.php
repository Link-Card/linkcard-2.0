{{-- Preview transition - animated waves matching public profile --}}
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? 'white';
    // Calculate alpha variants for waves
    if ($fillColor !== 'white') {
        $hex = ltrim($fillColor, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $fillAlpha70 = "rgba($r,$g,$b,0.7)";
        $fillAlpha50 = "rgba($r,$g,$b,0.5)";
        $fillAlpha30 = "rgba($r,$g,$b,0.3)";
    } else {
        $fillAlpha70 = 'rgba(255,255,255,0.7)';
        $fillAlpha50 = 'rgba(255,255,255,0.5)';
        $fillAlpha30 = 'rgba(255,255,255,0.3)';
    }
@endphp

@if($transition === 'wave')
    <div class="waves-container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs><path id="pw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
            <g class="parallax">
                <use xlink:href="#pw" x="48" y="0" fill="{{ $fillAlpha70 }}" />
                <use xlink:href="#pw" x="48" y="3" fill="{{ $fillAlpha50 }}" />
                <use xlink:href="#pw" x="48" y="5" fill="{{ $fillAlpha30 }}" />
                <use xlink:href="#pw" x="48" y="7" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>
@elseif($transition === 'double_wave')
    <div class="waves-container" style="height: 70px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs><path id="pdw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
            <g class="parallax">
                <use xlink:href="#pdw" x="48" y="0" fill="{{ $fillAlpha70 }}" />
                <use xlink:href="#pdw" x="48" y="2" fill="{{ $fillAlpha50 }}" />
                <use xlink:href="#pdw" x="48" y="4" fill="{{ $fillAlpha30 }}" />
                <use xlink:href="#pdw" x="48" y="6" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>
@elseif($transition === 'arch')
    <svg viewBox="0 0 400 40" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,0 Q200,80 400,0 L400,40 L0,40 Z" fill="{{ $fillColor }}" />
    </svg>
@elseif($transition === 'diagonal')
    <svg viewBox="0 0 400 25" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 400,20 400,25 0,25" fill="{{ $fillColor }}" />
    </svg>
@elseif($transition === 'chevron')
    <svg viewBox="0 0 400 20" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 200,20 400,0 400,20 0,20" fill="{{ $fillColor }}" />
    </svg>
@endif
