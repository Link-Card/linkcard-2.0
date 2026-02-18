{{-- Preview transition - animated waves matching public profile --}}
@once
<style>
    .waves-container { position: relative; width: 100%; height: 50px; overflow: hidden; }
    .waves-container svg { position: absolute; bottom: 0; width: 200%; height: 100%; }
    .waves-container .parallax > use { animation: wave-move 25s cubic-bezier(.55,.5,.45,.5) infinite; }
    .waves-container .parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
    .waves-container .parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
    .waves-container .parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
    .waves-container .parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }
    @keyframes wave-move { 0% { transform: translate3d(-90px,0,0); } 100% { transform: translate3d(85px,0,0); } }
</style>
@endonce
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? 'white';
    if ($fillColor !== 'white' && $fillColor !== '#FFFFFF') {
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
    <div class="waves-container" style="margin-bottom: -2px;">
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
    <div class="waves-container" style="height: 70px; margin-bottom: -2px;">
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
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,80 400,0 L400,40 L0,40 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'diagonal')
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 25" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,20 400,25 0,25" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'chevron')
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 20" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,20 400,0 400,20 0,20" fill="{{ $fillColor }}" />
        </svg>
    </div>
@endif
