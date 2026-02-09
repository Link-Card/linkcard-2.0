{{-- SVG Transitions between header and content --}}
{{-- Expects: $transition, $secondaryColor --}}
@php $transition = $transition ?? 'wave'; @endphp

@if($transition === 'wave')
    <svg viewBox="0 0 400 40" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,20 C80,38 150,5 220,22 C280,36 340,12 400,20 L400,40 L0,40 Z" fill="white" />
        <path d="M0,28 C60,35 130,10 200,28 C260,40 350,18 400,26 L400,40 L0,40 Z" fill="white" opacity="0.5" />
    </svg>

@elseif($transition === 'double_wave')
    <svg viewBox="0 0 400 50" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,15 C60,40 120,0 200,20 C280,40 340,5 400,18 L400,50 L0,50 Z" fill="{{ $secondaryColor }}" opacity="0.2" />
        <path d="M0,25 C80,45 160,5 240,28 C310,45 360,15 400,25 L400,50 L0,50 Z" fill="white" />
    </svg>

@elseif($transition === 'arch')
    <svg viewBox="0 0 400 35" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <ellipse cx="200" cy="0" rx="220" ry="35" fill="white" />
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
