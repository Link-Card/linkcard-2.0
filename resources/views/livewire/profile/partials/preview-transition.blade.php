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
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 30px;">
        <svg viewBox="0 0 400 30" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <path d="M0,15 C50,0 100,25 200,12 C300,0 350,20 400,10 L400,30 L0,30 Z" fill="{{ $fillAlpha['50'] }}" />
            <path d="M0,18 C80,8 150,28 250,14 C350,2 380,22 400,16 L400,30 L0,30 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'double_wave')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 40px;">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <path d="M0,20 C50,5 100,30 200,15 C300,2 350,25 400,12 L400,40 L0,40 Z" fill="{{ $fillAlpha['50'] }}" />
            <path d="M0,25 C60,10 130,32 220,18 C310,5 370,28 400,20 L400,40 L0,40 Z" fill="{{ $fillAlpha['90'] }}" />
            <path d="M0,30 C80,18 150,35 250,22 C350,10 380,30 400,25 L400,40 L0,40 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'arch')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 35px;">
        <svg viewBox="0 0 400 35" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,60 400,0 L400,35 L0,35 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'diagonal')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 25px;">
        <svg viewBox="0 0 400 25" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,18 400,25 0,25" fill="{{ $fillColor }}" />
        </svg>
    </div>
@elseif($transition === 'chevron')
    <div style="margin-top: -1px; margin-bottom: -2px; line-height: 0; height: 20px;">
        <svg viewBox="0 0 400 20" style="display: block; width: 100%; height: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,20 400,0 400,20 0,20" fill="{{ $fillColor }}" />
        </svg>
    </div>
@endif
