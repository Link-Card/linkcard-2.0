{{-- Preview transition SVG - used in preview.blade.php --}}
@php $transition = $transition ?? 'wave'; @endphp

@if($transition === 'wave')
    <svg viewBox="0 0 400 30" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,15 C80,28 150,3 220,16 C280,28 340,8 400,15 L400,30 L0,30 Z" fill="white" />
    </svg>
@elseif($transition === 'double_wave')
    <svg viewBox="0 0 400 35" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <path d="M0,10 C60,30 120,0 200,15 C280,30 340,3 400,12 L400,35 L0,35 Z" fill="{{ $secondary_color ?? '#1a5c3a' }}" opacity="0.2" />
        <path d="M0,18 C80,33 160,3 240,20 C310,33 360,10 400,18 L400,35 L0,35 Z" fill="white" />
    </svg>
@elseif($transition === 'arch')
    <svg viewBox="0 0 400 25" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <ellipse cx="200" cy="0" rx="220" ry="25" fill="white" />
    </svg>
@elseif($transition === 'diagonal')
    <svg viewBox="0 0 400 25" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 400,20 400,25 0,25" fill="white" />
    </svg>
@elseif($transition === 'chevron')
    <svg viewBox="0 0 400 20" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,0 200,20 400,0 400,20 0,20" fill="white" />
    </svg>
@endif
