{{-- Header: Entrepreneur (#12) - Bold business avec double cadre photo --}}
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 50%, {{ $primaryColor }}DD 100%);">
    {{-- Geometric business accent lines --}}
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);"></div>
    <div style="position: absolute; bottom: 0; right: 20px; width: 60px; height: 100%; background: rgba(255,255,255,0.04);"></div>
    <div style="position: absolute; bottom: 0; right: 90px; width: 30px; height: 100%; background: rgba(255,255,255,0.02);"></div>

    {{-- Secondary logo/photo (top-left) --}}
    @php $logoPath = $profile->template_config['logo_path'] ?? null; @endphp
    @if($logoPath)
        <div style="position: absolute; top: 16px; left: 16px; z-index: 5;">
            <img src="{{ Storage::url($logoPath) }}" class="w-10 h-10 rounded-full object-cover" style="border: 2px solid rgba(255,255,255,0.8); box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
        </div>
    @endif

    @include('profiles.partials.share-button')
    <div class="px-6 pt-14 pb-3 text-center relative" style="z-index: 1;">
        {{-- Photo avec cadre premium --}}
        <div class="flex justify-center mb-5">
            @if($profile->photo_path)
                <div class="relative">
                    <img src="{{ Storage::url($profile->photo_path) }}"
                         class="w-28 h-28 rounded-2xl object-cover shadow-2xl"
                         style="border: 3px solid rgba(255,255,255,0.9);">
                    {{-- Accent corner --}}
                    <div style="position: absolute; top: -4px; right: -4px; width: 16px; height: 16px; border-top: 3px solid {{ $primaryColor }}; border-right: 3px solid {{ $primaryColor }}; border-radius: 0 6px 0 0; background: transparent;"></div>
                </div>
            @else
                <div class="w-28 h-28 rounded-2xl shadow-2xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $secondaryColor }}); border: 3px solid rgba(255,255,255,0.9);">
                    <span class="text-5xl">👤</span>
                </div>
            @endif
        </div>
        @include('profiles.partials.info')
    </div>
    {{-- Sharp diagonal transition --}}
    <svg viewBox="0 0 400 35" style="display: block; width: 100%; margin-top: -1px;" preserveAspectRatio="none">
        <polygon points="0,10 400,25 400,35 0,35" fill="white" />
    </svg>
</div>
