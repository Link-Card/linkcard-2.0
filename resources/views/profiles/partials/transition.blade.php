{{-- SVG Transitions between header and content --}}
{{-- Now rendered INSIDE the header's gradient div = transparent areas show the gradient --}}
@php
    $transition = $transition ?? 'wave';
    $fillColor = $fillColor ?? 'white';

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
@endphp

@if($transition === 'wave' || $transition === 'double_wave')
    {{-- Embedded CSS for wave animation (v1 exact copy — immune to Tailwind CDN) --}}
    <style>
        .lc-waves {
            position: relative;
            width: 100%;
            height: 60px;
            margin-top: -1px;
            margin-bottom: -2px;
            overflow: hidden;
        }
        .lc-waves svg {
            display: block;
            width: 100%;
            height: 100%;
        }
        .lc-waves .parallax > use {
            animation: lc-wave-move 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .lc-waves .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .lc-waves .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .lc-waves .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .lc-waves .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        @keyframes lc-wave-move {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }
    </style>
@endif

@if($transition === 'wave')
    <div class="lc-waves">
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
    <div class="lc-waves" style="height: 70px;">
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
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 50" style="display: block; width: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,90 400,0 L400,50 L0,50 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'diagonal')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,30 400,40 0,40" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'chevron')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 30" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,30 400,0 400,30 0,30" fill="{{ $fillColor }}" />
        </svg>
    </div>

@endif
