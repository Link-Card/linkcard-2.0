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
        </div>
    </div>

    {{-- TEMPLATE SELECTION MODAL --}}
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
                            :style="filter === 'all' ? 'background: #42B574; color: white;' : 'color: #4B5563;'"
                            style="font-family: 'Manrope', sans-serif;">Tous</button>
                    <button @click="filter = 'general'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'general' ? 'background: #42B574; color: white;' : 'color: #4B5563;'"
                            style="font-family: 'Manrope', sans-serif;">Généraux</button>
                    <button @click="filter = 'specialized'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'specialized' ? 'background: #42B574; color: white;' : 'color: #4B5563;'"
                            style="font-family: 'Manrope', sans-serif;">Spécialisés</button>
                    <button @click="filter = 'custom'" class="flex-1 py-2 px-3 rounded-md text-xs font-semibold transition-all"
                            :style="filter === 'custom' ? 'background: #42B574; color: white;' : 'color: #4B5563;'"
                            style="font-family: 'Manrope', sans-serif;">Custom</button>
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
                             style="border: {{ $isActive ? '2px solid #42B574' : '1px solid #E5E7EB' }}; {{ !$canUse ? 'opacity: 0.6;' : '' }}"
                             @if($canUse)
                                 wire:click="changeTemplate('{{ $slug }}')"
                                 @click="showModal = false"
                                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)'"
                                 onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)'"
                             @endif>
                            
                            {{-- Mini header preview --}}
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
                                @else
                                    <div style="height: 48px; background: linear-gradient({{ $tpl['header_style'] === 'diagonal' ? '135deg' : '180deg' }}, {{ $primary_color }}, {{ $secondary_color }});"></div>
                                @endif
                                
                                {{-- Transition preview --}}
                                @if($tpl['transition'] === 'wave' || $tpl['transition'] === 'double_wave')
                                    <svg viewBox="0 0 200 12" style="display: block; width: 100%; margin-top: -1px; height: 10px;" preserveAspectRatio="none">
                                        <path d="M0,6 C40,12 80,0 120,8 C160,14 180,4 200,6 L200,12 L0,12 Z" fill="white" />
                                    </svg>
                                @elseif($tpl['transition'] === 'arch')
                                    <svg viewBox="0 0 200 10" style="display: block; width: 100%; margin-top: -1px; height: 8px;" preserveAspectRatio="none">
                                        <ellipse cx="100" cy="0" rx="110" ry="10" fill="white" />
                                    </svg>
                                @elseif($tpl['transition'] === 'diagonal')
                                    <svg viewBox="0 0 200 10" style="display: block; width: 100%; margin-top: -1px; height: 8px;" preserveAspectRatio="none">
                                        <polygon points="0,0 200,8 200,10 0,10" fill="white" />
                                    </svg>
                                @elseif($tpl['transition'] === 'chevron')
                                    <svg viewBox="0 0 200 10" style="display: block; width: 100%; margin-top: -1px; height: 8px;" preserveAspectRatio="none">
                                        <polygon points="0,0 100,10 200,0 200,10 0,10" fill="white" />
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
                                        <div class="w-5 h-5 {{ $tpl['photo_style'] === 'square_center' ? 'rounded-md' : 'rounded-full' }} bg-white/30" style="border: 1.5px solid white;"></div>
                                    </div>
                                @endif
                            </div>

                            {{-- Content preview --}}
                            <div class="bg-white px-3 py-2.5">
                                {{-- Fake social indicators --}}
                                <div class="flex gap-1 justify-center mb-1.5">
                                    @if($tpl['social_style'] === 'circles')
                                        @for($i = 0; $i < 3; $i++)
                                            <div class="w-3 h-3 rounded-full" style="background: {{ $primary_color }}15; border: 0.5px solid {{ $primary_color }}30;"></div>
                                        @endfor
                                    @elseif($tpl['social_style'] === 'list')
                                        <div class="w-full space-y-1">
                                            @for($i = 0; $i < 2; $i++)
                                                <div class="h-2 rounded" style="background: #F3F4F6; border: 0.5px solid #E5E7EB;"></div>
                                            @endfor
                                        </div>
                                    @else {{-- pills --}}
                                        @for($i = 0; $i < 3; $i++)
                                            <div class="h-2.5 rounded-full" style="width: 24px; background: #F3F4F6;"></div>
                                        @endfor
                                    @endif
                                </div>

                                {{-- Feature indicators --}}
                                @if(in_array('video_embed', $tpl['features'] ?? []))
                                    <div class="h-2 rounded mt-1" style="background: #FEE2E2;"></div>
                                @endif
                                @if(in_array('image_carousel', $tpl['features'] ?? []))
                                    <div class="h-2 rounded mt-1" style="background: #FEF3C7;"></div>
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
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md" style="background: #42B574; color: white;">ACTIF</span>
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
                                <div class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full flex items-center justify-center" style="background: #42B574;">
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
