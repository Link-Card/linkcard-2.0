{{-- SVG Transitions between header and content --}}
{{-- Expects: $transition, $secondaryColor --}}
@php $transition = $transition ?? 'wave'; @endphp

@if($transition === 'wave')
    {{-- Animated wave from Link-Card v1 --}}
    <div class="waves-container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="white" />
            </g>
        </svg>
    </div>

@elseif($transition === 'double_wave')
    {{-- Double animated wave (v1 style, taller) --}}
    <div class="waves-container" style="height: 70px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave-dbl" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave-dbl" x="48" y="0" fill="rgba(255,255,255,0.6)" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="2" fill="rgba(255,255,255,0.4)" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="4" fill="rgba(255,255,255,0.2)" />
                <use xlink:href="#gentle-wave-dbl" x="48" y="6" fill="white" />
            </g>
        </svg>
    </div>

@elseif($transition === 'arch')
    <svg viewBox="0 0 400 40" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <ellipse cx="200" cy="0" rx="220" ry="40" fill="white" />
    </svg>

@elseif($transition === 'diagonal')
    <svg viewBox="0 0 400 40" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 400,30 400,40 0,40" fill="white" />
    </svg>

@elseif($transition === 'chevron')
    <svg viewBox="0 0 400 30" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 200,30 400,0 400,30 0,30" fill="white" />
    </svg>

@endif
{{-- 'none' = rien affiché --}}
