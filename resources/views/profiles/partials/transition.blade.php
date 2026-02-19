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

@if($transition === 'wave')
    <div style="position: relative; width: 100%; height: 60px; overflow: hidden; margin-bottom: -2px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"
             style="display: block; width: 100%; height: 100%;">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g>
                <use xlink:href="#gentle-wave" x="48" y="0" fill="{{ $fillAlpha['70'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="7s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave" x="48" y="3" fill="{{ $fillAlpha['50'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="10s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave" x="48" y="5" fill="{{ $fillAlpha['30'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="13s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave" x="48" y="7" fill="{{ $fillColor }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="20s" repeatCount="indefinite" />
                </use>
            </g>
        </svg>
    </div>

@elseif($transition === 'double_wave')
    <div style="position: relative; width: 100%; height: 70px; overflow: hidden; margin-bottom: -2px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto"
             style="display: block; width: 100%; height: 100%;">
            <defs>
                <path id="gentle-wave-dbl" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g>
                <use xlink:href="#gentle-wave-dbl" x="48" y="0" fill="{{ $fillAlpha['70'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="5s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave-dbl" x="48" y="2" fill="{{ $fillAlpha['50'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="8s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave-dbl" x="48" y="4" fill="{{ $fillAlpha['30'] }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="11s" repeatCount="indefinite" />
                </use>
                <use xlink:href="#gentle-wave-dbl" x="48" y="6" fill="{{ $fillColor }}">
                    <animateTransform attributeName="transform" type="translate" from="-90,0" to="85,0" dur="15s" repeatCount="indefinite" />
                </use>
            </g>
        </svg>
    </div>

@elseif($transition === 'arch')
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 50" style="display: block; width: 100%;" preserveAspectRatio="none">
            <path d="M0,0 Q200,90 400,0 L400,50 L0,50 Z" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'diagonal')
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 40" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 400,30 400,40 0,40" fill="{{ $fillColor }}" />
        </svg>
    </div>

@elseif($transition === 'chevron')
    <div style="margin-bottom: -2px; line-height: 0;">
        <svg viewBox="0 0 400 30" style="display: block; width: 100%;" preserveAspectRatio="none">
            <polygon points="0,0 200,30 400,0 400,30 0,30" fill="{{ $fillColor }}" />
        </svg>
    </div>

@endif
