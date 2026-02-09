{{-- Preview transition - animated waves matching public profile --}}
@php $transition = $transition ?? 'wave'; @endphp

@if($transition === 'wave')
    <div class="waves-container">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs><path id="pw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
            <g class="parallax">
                <use xlink:href="#pw" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                <use xlink:href="#pw" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#pw" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#pw" x="48" y="7" fill="white" />
            </g>
        </svg>
    </div>
@elseif($transition === 'double_wave')
    <div class="waves-container" style="height: 70px;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs><path id="pdw" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
            <g class="parallax">
                <use xlink:href="#pdw" x="48" y="0" fill="rgba(255,255,255,0.6)" />
                <use xlink:href="#pdw" x="48" y="2" fill="rgba(255,255,255,0.4)" />
                <use xlink:href="#pdw" x="48" y="4" fill="rgba(255,255,255,0.2)" />
                <use xlink:href="#pdw" x="48" y="6" fill="white" />
            </g>
        </svg>
    </div>
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
