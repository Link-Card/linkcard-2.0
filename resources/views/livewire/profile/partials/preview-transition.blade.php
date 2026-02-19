{{-- Preview Transition SVGs - rendered INSIDE gradient div = transparent shows gradient --}}
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? '#FFFFFF';

    // Convert fillColor to rgba variants for semi-transparent SVG fills
    $hex = ltrim($fillColor, '#');
    if (strlen($hex) === 6) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    } else {
        $r = 255; $g = 255; $b = 255;
    }
    $fillAlpha = [
        '90' => "rgba($r,$g,$b,0.9)",
        '70' => "rgba($r,$g,$b,0.7)",
        '50' => "rgba($r,$g,$b,0.5)",
    ];
@endphp

@if($transition === 'wave')
    <style>
        .pv-waves { position: relative; z-index: 5; width: 100%; height: 30px; margin-top: -1px; margin-bottom: -2px; overflow: hidden; }
        .pv-waves .pv-parallax > use { animation: pv-wave-move 25s cubic-bezier(.55,.5,.45,.5) infinite; }
        .pv-waves .pv-parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
        .pv-waves .pv-parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
        .pv-waves .pv-parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
        .pv-waves .pv-parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }
        @keyframes pv-wave-move { 0% { transform: translate3d(-90px,0,0); } 100% { transform: translate3d(85px,0,0); } }
    </style>
    <div class="pv-waves">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"
             style="display: block; width: 100%; height: 100%;">
            <defs>
                <path id="pw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="pv-parallax">
                <use xlink:href="#pw" x="48" y="0" fill="{{ $fillAlpha['70'] }}" />
                <use xlink:href="#pw" x="48" y="3" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#pw" x="48" y="5" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#pw" x="48" y="7" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>
@elseif($transition === 'double_wave')
    <style>
        .pv-dwaves { position: relative; z-index: 5; width: 100%; height: 35px; margin-top: -1px; margin-bottom: -2px; overflow: hidden; }
        .pv-dwaves .pv-dparallax > use { animation: pv-dwave-move 25s cubic-bezier(.55,.5,.45,.5) infinite; }
        .pv-dwaves .pv-dparallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
        .pv-dwaves .pv-dparallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
        .pv-dwaves .pv-dparallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
        .pv-dwaves .pv-dparallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }
        @keyframes pv-dwave-move { 0% { transform: translate3d(-90px,0,0); } 100% { transform: translate3d(85px,0,0); } }
    </style>
    <div class="pv-dwaves">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"
             style="display: block; width: 100%; height: 100%;">
            <defs>
                <path id="pdw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="pv-dparallax">
                <use xlink:href="#pdw" x="48" y="0" fill="{{ $fillAlpha['70'] }}" />
                <use xlink:href="#pdw" x="48" y="2" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#pdw" x="48" y="4" fill="{{ $fillAlpha['50'] }}" />
                <use xlink:href="#pdw" x="48" y="6" fill="{{ $fillColor }}" />
            </g>
        </svg>
    </div>
@elseif($transition === 'arch')
    <div style="position: relative; z-index: 5; margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 35px;">
        <svg viewBox="0 0 400 50" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,90 400,0 L400,50 L0,50 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'diagonal')
    <div style="position: relative; z-index: 5; margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 25px;">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,30 400,40 0,40" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'chevron')
    <div style="position: relative; z-index: 5; margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 20px;">
        <svg viewBox="0 0 400 30" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,30 400,0 400,30 0,30" fill="{{ $fillColor }}" />
        </svg>
    </div>
@endif
