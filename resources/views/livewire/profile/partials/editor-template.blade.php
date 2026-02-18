{{-- Template Selector Section --}}
@php
    $currentTemplate = $profile->template_id ?? 'classic';
    $currentConfig = \App\Services\TemplateService::get($currentTemplate);
    $userPlan = auth()->user()->plan ?? 'free';
    $allTemplates = \App\Services\TemplateService::all();
    $planHierarchy = ['free' => 0, 'pro' => 1, 'premium' => 2];
    $userLevel = $planHierarchy[$userPlan] ?? 0;
@endphp

<div x-data="{ open: false, showModal: false }" x-cloak
     class="bg-white rounded-xl overflow-hidden"
     style="border: 1px solid #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    
    {{-- Collapsible Header --}}
    <button @click="open = !open"
            class="w-full flex items-center justify-between px-5 py-4 transition-colors"
            style="font-family: 'Manrope', sans-serif;"
            :style="open ? 'background: #FAFAFA' : ''">
        <div class="flex items-center space-x-3">
            <span class="text-lg">🎨</span>
            <span class="font-medium text-sm" style="color: #2C2A27;">Template du profil</span>
            <span class="text-xs px-2 py-0.5 rounded-full font-medium" style="background: #F0F9F4; color: #42B574;">{{ $currentConfig['name'] ?? 'Classique' }}</span>
        </div>
        <svg class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #9CA3AF;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" x-transition style="border-top: 1px solid #E5E7EB;">
        <div class="px-5 py-5">
            
            {{-- Current template preview --}}
            <div class="flex items-center gap-4 p-3 rounded-xl mb-4" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                {{-- Mini preview --}}
                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0" style="border: 1px solid #E5E7EB;">
                    <div class="w-full h-10" style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                    <div class="w-full h-6 bg-white flex items-center justify-center">
                        <div class="w-4 h-4 rounded-full -mt-2" style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }}); border: 1px solid white; box-shadow: 0 1px 2px rgba(0,0,0,0.1);"></div>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">{{ $currentConfig['name'] ?? 'Classique' }}</p>
                    <p class="text-xs" style="color: #9CA3AF; font-family: 'Manrope', sans-serif;">{{ $currentConfig['description'] ?? '' }}</p>
                </div>
            </div>

            {{-- Change template button --}}
            <button @click="showModal = true"
                    class="w-full py-2.5 rounded-lg font-medium text-sm transition-all duration-200 flex items-center justify-center space-x-2"
                    style="font-family: 'Manrope', sans-serif; background: #F0F9F4; color: #42B574; border: 1px solid #42B574;"
                    onmouseover="this.style.background='#42B574'; this.style.color='#FFFFFF'"
                    onmouseout="this.style.background='#F0F9F4'; this.style.color='#42B574'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                <span>Changer de template</span>
            </button>

            {{-- Entrepreneur logo upload (only for entrepreneur template) --}}
            @if($currentTemplate === 'entrepreneur')
                @php $logoPath = $profile->template_config['logo_path'] ?? null; @endphp
                <div class="mt-4 p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                    <p class="text-xs font-semibold mb-2" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Logo / 2e photo (coin supérieur droit)
                    </p>
                    @if($logoPath)
                        <div class="flex items-center gap-3">
                            <img src="{{ Storage::url($logoPath) }}" class="w-12 h-12 rounded-full object-cover" style="border: 2px solid #E5E7EB;">
                            <div class="flex-1">
                                <p class="text-xs" style="color: #6B7280;">Logo actuel</p>
                            </div>
                            <button wire:click="removeEntrepreneurLogo" class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all"
                                    style="color: #EF4444; background: #FEF2F2; border: 1px solid #FECACA;"
                                    onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='#FEF2F2'">
                                Retirer
                            </button>
                        </div>
                        <div class="mt-2">
                            <label class="text-xs cursor-pointer font-medium px-3 py-1.5 rounded-lg inline-flex items-center gap-1 transition-all"
                                   style="color: #4B5563; background: #F3F4F6; border: 1px solid #E5E7EB;"
                                   onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                                Changer
                                <input type="file" wire:model="entrepreneurLogo" accept="image/*" class="hidden">
                            </label>
                        </div>
                    @else
                        <label class="flex flex-col items-center justify-center py-4 cursor-pointer rounded-lg transition-all"
                               style="border: 2px dashed #D1D5DB;"
                               onmouseover="this.style.borderColor='#42B574'; this.style.background='#F0F9F4'" onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="#9CA3AF" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            <span class="text-xs font-medium" style="color: #9CA3AF;">Ajouter un logo</span>
                            <span class="text-[10px] mt-0.5" style="color: #D1D5DB;">Affiché en haut à gauche du header</span>
                            <input type="file" wire:model="entrepreneurLogo" accept="image/*" class="hidden">
                        </label>
                    @endif

                    {{-- Loading state --}}
                    <div wire:loading wire:target="entrepreneurLogo" class="mt-2">
                        <div class="flex items-center gap-2 text-xs" style="color: #42B574;">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Téléchargement...
                        </div>
                    </div>

                    @error('entrepreneurLogo')
                        <p class="text-xs mt-1" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Custom template configurator (Mon Style) --}}
            @if($currentTemplate === 'custom')
                @php
                    $customConfig = $profile->template_config ?? [];
                    $activeHeader = $customConfig['header_style'] ?? 'classic';
                    $activeTransition = $customConfig['transition'] ?? 'wave';
                    $activePhoto = $customConfig['photo_style'] ?? 'round_center';
                    $activeSocial = $customConfig['social_style'] ?? 'pills';
                    $activeButton = $customConfig['button_style'] ?? 'rounded';
                @endphp
                <div class="mt-4 space-y-4">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm">✨</span>
                        <p class="text-xs font-semibold uppercase tracking-wider" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Personnalisation</p>
                    </div>

                    {{-- Header Style --}}
                    <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                        <p class="text-xs font-semibold mb-3" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Style du header</p>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(\App\Services\TemplateService::headerStyles() as $styleKey => $styleName)
                                <button wire:click="updateCustomConfig('header_style', '{{ $styleKey }}')"
                                        class="relative rounded-lg overflow-hidden transition-all duration-200"
                                        style="border: {{ $activeHeader === $styleKey ? '2px solid #42B574' : '1px solid #E5E7EB' }}; {{ $activeHeader === $styleKey ? 'box-shadow: 0 0 0 1px #42B574;' : '' }}"
                                        onmouseover="if('{{ $activeHeader }}' !== '{{ $styleKey }}') this.style.borderColor='#42B574'"
                                        onmouseout="if('{{ $activeHeader }}' !== '{{ $styleKey }}') this.style.borderColor='#E5E7EB'">
                                    {{-- Mini preview --}}
                                    @if($styleKey === 'bold')
                                        <div style="height: 28px; background: #2C2A27; position: relative;">
                                            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                        </div>
                                    @elseif($styleKey === 'minimal')
                                        <div style="height: 2px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                        <div style="height: 26px; background: white;"></div>
                                    @elseif($styleKey === 'banner')
                                        <div style="height: 18px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                        <div style="height: 10px; background: white;"></div>
                                    @elseif($styleKey === 'videaste')
                                        <div style="height: 28px; background: linear-gradient(135deg, #1a1a2e 0%, {{ $primary_color }}CC 50%, {{ $secondary_color }} 100%); position: relative;">
                                            <div style="position: absolute; width: 3px; height: 3px; border-radius: 50%; background: white; top: 20%; left: 20%; opacity: 0.5;"></div>
                                            <div style="position: absolute; width: 2px; height: 2px; border-radius: 50%; background: {{ $primary_color }}; top: 50%; right: 25%; opacity: 0.7;"></div>
                                        </div>
                                    @elseif($styleKey === 'artiste')
                                        <div style="height: 28px; background: linear-gradient(160deg, {{ $primary_color }}, {{ $secondary_color }}); position: relative; overflow: hidden;">
                                            <div style="position: absolute; top: -5px; right: -5px; width: 20px; height: 20px; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; background: rgba(255,255,255,0.1);"></div>
                                        </div>
                                    @elseif($styleKey === 'entrepreneur')
                                        <div style="height: 28px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }}); position: relative;">
                                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);"></div>
                                            <div style="position: absolute; right: 8px; top: 0; bottom: 0; width: 8px; background: rgba(255,255,255,0.06);"></div>
                                        </div>
                                    @else
                                        <div style="height: 28px; background: linear-gradient({{ $styleKey === 'diagonal' ? '135deg' : '180deg' }}, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                    @endif
                                    <div class="py-1.5 bg-white">
                                        <p class="text-[10px] text-center font-medium" style="color: #4B5563; font-family: 'Manrope', sans-serif;">{{ $styleName }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Transition --}}
                    <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                        <p class="text-xs font-semibold mb-3" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Transition</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Services\TemplateService::transitions() as $transKey => $transName)
                                <button wire:click="updateCustomConfig('transition', '{{ $transKey }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                        style="font-family: 'Manrope', sans-serif; {{ $activeTransition === $transKey ? 'background: #42B574; color: white;' : 'background: white; color: #4B5563; border: 1px solid #E5E7EB;' }}"
                                        onmouseover="if('{{ $activeTransition }}' !== '{{ $transKey }}') this.style.borderColor='#42B574'"
                                        onmouseout="if('{{ $activeTransition }}' !== '{{ $transKey }}') this.style.borderColor='#E5E7EB'">
                                    {{ $transName }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Photo Style --}}
                    <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                        <p class="text-xs font-semibold mb-3" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Style de la photo</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Services\TemplateService::photoStyles() as $photoKey => $photoName)
                                <button wire:click="updateCustomConfig('photo_style', '{{ $photoKey }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                        style="font-family: 'Manrope', sans-serif; {{ $activePhoto === $photoKey ? 'background: #42B574; color: white;' : 'background: white; color: #4B5563; border: 1px solid #E5E7EB;' }}"
                                        onmouseover="if('{{ $activePhoto }}' !== '{{ $photoKey }}') this.style.borderColor='#42B574'"
                                        onmouseout="if('{{ $activePhoto }}' !== '{{ $photoKey }}') this.style.borderColor='#E5E7EB'">
                                    {{ $photoName }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Social Style --}}
                    <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                        <p class="text-xs font-semibold mb-3" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Style des liens sociaux</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Services\TemplateService::socialStyles() as $socialKey => $socialName)
                                <button wire:click="updateCustomConfig('social_style', '{{ $socialKey }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                        style="font-family: 'Manrope', sans-serif; {{ $activeSocial === $socialKey ? 'background: #42B574; color: white;' : 'background: white; color: #4B5563; border: 1px solid #E5E7EB;' }}"
                                        onmouseover="if('{{ $activeSocial }}' !== '{{ $socialKey }}') this.style.borderColor='#42B574'"
                                        onmouseout="if('{{ $activeSocial }}' !== '{{ $socialKey }}') this.style.borderColor='#E5E7EB'">
                                    {{ $socialName }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Button Style --}}
                    <div class="p-4 rounded-xl" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
                        <p class="text-xs font-semibold mb-3" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Style des boutons</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Services\TemplateService::buttonStyles() as $btnKey => $btnName)
                                <button wire:click="updateCustomConfig('button_style', '{{ $btnKey }}')"
                                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200"
                                        style="font-family: 'Manrope', sans-serif; {{ $activeButton === $btnKey ? 'background: #42B574; color: white;' : 'background: white; color: #4B5563; border: 1px solid #E5E7EB;' }}"
                                        onmouseover="if('{{ $activeButton }}' !== '{{ $btnKey }}') this.style.borderColor='#42B574'"
                                        onmouseout="if('{{ $activeButton }}' !== '{{ $btnKey }}') this.style.borderColor='#E5E7EB'">
                                    {{ $btnName }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div x-show="showModal" x-transition.opacity
         class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto"
         style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); padding: 20px 16px;"
         @click.self="showModal = false"
         @keydown.escape.window="showModal = false">
        
        <div class="w-full max-w-2xl bg-white rounded-2xl overflow-hidden my-4" style="box-shadow: 0 20px 60px rgba(0,0,0,0.2);" @click.stop>
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom: 1px solid #E5E7EB;">
                <div>
                    <h3 class="text-lg font-semibold" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">Choisir un template</h3>
                    <p class="text-xs mt-0.5" style="color: #9CA3AF; font-family: 'Manrope', sans-serif;">Votre contenu sera préservé</p>
                </div>
                <button @click="showModal = false" class="p-2 rounded-lg transition-colors" style="color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Filter tabs --}}
            <div x-data="{ filter: 'all' }" class="px-5 pt-4 pb-2">
                <div class="flex gap-1 p-1 rounded-lg" style="background: #F3F4F6;">
                    <button @click="filter = 'all'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'all' ? 'background: white; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #9CA3AF;'"
                            style="font-family: 'Manrope', sans-serif;">Tous</button>
                    <button @click="filter = 'general'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'general' ? 'background: white; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #9CA3AF;'"
                            style="font-family: 'Manrope', sans-serif;">Généraux</button>
                    <button @click="filter = 'specialized'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'specialized' ? 'background: white; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #9CA3AF;'"
                            style="font-family: 'Manrope', sans-serif;">Spécialisés</button>
                    <button @click="filter = 'custom'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'custom' ? 'background: white; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.08);' : 'color: #9CA3AF;'"
                            style="font-family: 'Manrope', sans-serif;">Mon Style</button>
                </div>

                {{-- Templates Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4 pb-4 max-h-[60vh] overflow-y-auto">
                    @foreach($allTemplates as $slug => $tpl)
                        @php
                            $requiredLevel = $planHierarchy[$tpl['required_plan']] ?? 0;
                            $canUse = $userLevel >= $requiredLevel;
                            $isActive = $currentTemplate === $slug;
                            $planLabel = match($tpl['required_plan']) { 'pro' => 'PRO', 'premium' => 'PREMIUM', default => '' };
                        @endphp
                        
                        <div x-show="filter === 'all' || filter === '{{ $tpl['category'] }}'"
                             x-transition
                             class="relative rounded-xl overflow-hidden cursor-pointer transition-all duration-200"
                             style="border: {{ $isActive ? '2px solid #2C2A27' : '1px solid #E5E7EB' }}; {{ !$canUse ? 'opacity: 0.6;' : '' }}"
                             @if($canUse)
                                 wire:click="changeTemplate('{{ $slug }}')"
                                 @click="showModal = false"
                                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)'"
                                 onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)'"
                             @endif>
                            
                            {{-- Mini header preview --}}
                            @php $tplDark = $tpl['dark_mode'] ?? false; $tplBodyBg = $tpl['body_bg'] ?? '#FFFFFF'; @endphp
                            <div class="relative">
                                @if($tpl['header_style'] === 'bold')
                                    <div style="height: 48px; background: #2C2A27; position: relative;">
                                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                    </div>
                                @elseif($tpl['header_style'] === 'minimal')
                                    <div style="height: 3px; background: linear-gradient(90deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                    <div style="height: 45px; background: white;"></div>
                                @elseif($tpl['header_style'] === 'banner')
                                    <div style="height: 32px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                    <div style="height: 16px; background: white;"></div>
                                @elseif($tpl['header_style'] === 'geometric')
                                    <div style="height: 48px; background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }}); position: relative; overflow: hidden;">
                                        <div style="position: absolute; top: -5px; right: 10px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.08);"></div>
                                        <div style="position: absolute; bottom: 5px; left: -5px; width: 20px; height: 20px; background: rgba(255,255,255,0.05); transform: rotate(45deg);"></div>
                                    </div>
                                @elseif($tpl['header_style'] === 'neon')
                                    <div style="height: 48px; background: linear-gradient(160deg, #0A0A18 0%, {{ $primary_color }}30 40%, {{ $secondary_color }}50 70%, #0F0F1A 100%); position: relative; overflow: hidden;">
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 40px; height: 40px; background: radial-gradient(circle, {{ $primary_color }}20 0%, transparent 70%); filter: blur(10px);"></div>
                                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, {{ $primary_color }}40, transparent);"></div>
                                    </div>
                                @else
                                    <div style="height: 48px; background: linear-gradient({{ $tpl['header_style'] === 'diagonal' ? '135deg' : '180deg' }}, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                @endif
                                
                                {{-- Transition preview --}}
                                @if($tpl['transition'] === 'wave' || $tpl['transition'] === 'double_wave')
                                    <svg viewBox="0 0 200 12" style="display: block; width: 100%; margin-top: -1px; height: 10px;" preserveAspectRatio="none">
                                        <path d="M0,6 C40,12 80,0 120,8 C160,14 180,4 200,6 L200,12 L0,12 Z" fill="{{ $tplBodyBg }}" />
                                    </svg>
                                @elseif($tpl['transition'] === 'arch')
                                    <svg viewBox="0 0 200 12" style="display: block; width: 100%; margin-top: -1px; height: 10px;" preserveAspectRatio="none">
                                        <path d="M0,0 Q100,24 200,0 L200,12 L0,12 Z" fill="{{ $tplBodyBg }}" />
                                    </svg>
                                @elseif($tpl['transition'] === 'diagonal')
                                    <svg viewBox="0 0 200 10" style="display: block; width: 100%; margin-top: -1px; height: 8px;" preserveAspectRatio="none">
                                        <polygon points="0,0 200,8 200,10 0,10" fill="{{ $tplBodyBg }}" />
                                    </svg>
                                @elseif($tpl['transition'] === 'chevron')
                                    <svg viewBox="0 0 200 10" style="display: block; width: 100%; margin-top: -1px; height: 8px;" preserveAspectRatio="none">
                                        <polygon points="0,0 100,10 200,0 200,10 0,10" fill="{{ $tplBodyBg }}" />
                                    </svg>
                                @endif

                                {{-- Photo dot --}}
                                @if($tpl['header_style'] === 'banner')
                                    <div class="absolute" style="left: 50%; top: 20px; transform: translateX(-50%);">
                                        <div class="w-5 h-5 rounded-full" style="background: linear-gradient(135deg, {{ $primary_color }}, {{ $secondary_color }}); border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.15);"></div>
                                    </div>
                                @elseif($tpl['header_style'] === 'split')
                                    <div class="absolute" style="left: 15%; top: 50%; transform: translate(-50%, -50%);">
                                        <div class="w-5 h-5 rounded-full bg-white/30" style="border: 1.5px solid white;"></div>
                                    </div>
                                @elseif($tpl['header_style'] !== 'minimal')
                                    <div class="absolute" style="left: 50%; top: 14px; transform: translateX(-50%);">
                                        <div class="w-5 h-5 {{ $tpl['photo_style'] === 'square_center' ? 'rounded-md' : 'rounded-full' }}" style="background: {{ $tplDark ? 'rgba(255,255,255,0.15)' : 'rgba(255,255,255,0.3)' }}; border: 1.5px solid {{ $tplDark ? $primary_color : 'white' }};{{ $tplDark ? ' box-shadow: 0 0 6px '.$primary_color.'40;' : '' }}"></div>
                                    </div>
                                @endif
                            </div>

                            {{-- Content preview --}}
                            <div class="px-3 py-2.5" style="background: {{ $tplBodyBg }};">
                                {{-- Fake social indicators --}}
                                <div class="flex gap-1 justify-center mb-1.5">
                                    @if($tpl['social_style'] === 'circles')
                                        @for($i = 0; $i < 3; $i++)
                                            <div class="w-3 h-3 rounded-full" style="background: {{ $tplDark ? $primary_color.'15' : $primary_color.'15' }}; border: 0.5px solid {{ $tplDark ? $primary_color.'30' : $primary_color.'30' }};{{ $tplDark ? ' box-shadow: 0 0 4px '.$primary_color.'15;' : '' }}"></div>
                                        @endfor
                                    @elseif($tpl['social_style'] === 'list')
                                        <div class="w-full space-y-1">
                                            @for($i = 0; $i < 2; $i++)
                                                <div class="h-2 rounded" style="background: {{ $tplDark ? '#1A1A2E' : '#F3F4F6' }}; border: 0.5px solid {{ $tplDark ? $primary_color.'20' : '#E5E7EB' }};"></div>
                                            @endfor
                                        </div>
                                    @else {{-- pills --}}
                                        @for($i = 0; $i < 3; $i++)
                                            <div class="h-2.5 rounded-full" style="width: 24px; background: {{ $tplDark ? '#1A1A2E' : '#F3F4F6' }};"></div>
                                        @endfor
                                    @endif
                                </div>

                                {{-- Feature indicators --}}
                                @if(in_array('video_embed', $tpl['features'] ?? []))
                                    <div class="h-2 rounded mt-1" style="background: {{ $tplDark ? '#2A1A1A' : '#FEE2E2' }};"></div>
                                @endif
                                @if(in_array('image_carousel', $tpl['features'] ?? []))
                                    <div class="h-2 rounded mt-1" style="background: {{ $tplDark ? '#2A2A1A' : '#FEF3C7' }};"></div>
                                @endif
                                @if(in_array('cta_buttons', $tpl['features'] ?? []))
                                    <div class="h-2 rounded mt-1" style="background: {{ $primary_color }}20;"></div>
                                @endif
                            </div>

                            {{-- Template name --}}
                            <div class="px-3 py-2" style="border-top: 1px solid #F3F4F6;">
                                <p class="text-xs font-semibold truncate" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">{{ $tpl['name'] }}</p>
                                <p class="text-[10px] truncate" style="color: #9CA3AF; font-family: 'Manrope', sans-serif;">{{ $tpl['description'] }}</p>
                            </div>

                            {{-- Badges --}}
                            <div class="absolute top-1.5 left-1.5 flex gap-1">
                                @if($isActive)
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md" style="background: #2C2A27; color: white;">ACTIF</span>
                                @endif
                                @if($tpl['category'] === 'specialized')
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md" style="background: #FEF3C7; color: #92400E;">SPÉCIAL</span>
                                @endif
                            </div>

                            {{-- Lock / Plan badge --}}
                            @if(!$canUse)
                                <div class="absolute top-1.5 right-1.5">
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: white;">{{ $planLabel }}</span>
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center" style="background: rgba(255,255,255,0.4);">
                                    <svg class="w-5 h-5" fill="#9CA3AF" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                </div>
                            @endif

                            {{-- Active check --}}
                            @if($isActive)
                                <div class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center" style="background: #2C2A27;">
                                    <svg class="w-3 h-3" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
