{{-- Header: Entrepreneur (#12) - Bold business avec double cadre photo --}}
<div style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 50%, {{ $primaryColor }}DD 100%);">
    <div class="relative overflow-hidden">
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
            @include('profiles.partials.photo', [
                'photoStyle' => $templateConfig['photo_style'] ?? 'square_center',
                'extraStyle' => 'border: 3px solid rgba(255,255,255,0.9);',
            ])
            @include('profiles.partials.info')
        </div>
    </div>
    @include('profiles.partials.transition', ['transition' => $templateTransition ?? 'diagonal'])
</div>
