<div class="py-6 sm:py-8">

    {{-- ═══════════════════════════════════════ --}}
    {{-- ONBOARDING MODAL (3 slides) --}}
    {{-- ═══════════════════════════════════════ --}}
    @if($showOnboardingModal)
    <div x-data="{ slide: 1 }" 
         x-show="$wire.showOnboardingModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4"
         style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">

        <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden relative"
             style="box-shadow: 0 25px 50px rgba(0,0,0,0.15);"
             @click.away="$wire.closeModal()">

            {{-- Close button --}}
            <button @click="$wire.closeModal()" class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full flex items-center justify-center transition-colors" style="background: #F3F4F6;" onmouseover="this.style.background='#E5E7EB'" onmouseout="this.style.background='#F3F4F6'">
                <svg class="w-4 h-4" style="color: #4B5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            {{-- Slide 1: Bienvenue --}}
            <div x-show="slide === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="pt-10 pb-6 px-8 text-center">
                    {{-- Logo --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #42B574, #4A7FBF);">
                        <img src="{{ asset('images/logo-blanc.png') }}" alt="Link-Card" class="h-12 w-auto">
                    </div>

                    <h2 class="text-2xl font-semibold mb-3" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                        Bienvenue sur Link-Card!
                    </h2>
                    <p class="text-sm leading-relaxed mb-8" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                        Votre profil digital professionnel est prêt à être créé. On vous guide en <strong>3 étapes simples</strong>.
                    </p>

                    {{-- Dots --}}
                    <div class="flex items-center justify-center space-x-2 mb-6">
                        <div class="w-2.5 h-2.5 rounded-full" style="background: #42B574;"></div>
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                    </div>

                    <button @click="slide = 2" class="w-full py-3 px-6 rounded-xl text-white font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                        Suivant →
                    </button>
                </div>
            </div>

            {{-- Slide 2: Personnalisez --}}
            <div x-show="slide === 2" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="pt-10 pb-6 px-8 text-center">
                    {{-- Icon --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center" style="background: #F0F9F4;">
                        <svg class="w-10 h-10" fill="none" stroke="#42B574" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-semibold mb-3" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                        Personnalisez votre profil
                    </h2>
                    <p class="text-sm leading-relaxed mb-8" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                        Ajoutez votre photo, vos infos et vos liens sociaux. Choisissez un template qui vous ressemble parmi <strong>13 designs</strong> disponibles.
                    </p>

                    {{-- Dots --}}
                    <div class="flex items-center justify-center space-x-2 mb-6">
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                        <div class="w-2.5 h-2.5 rounded-full" style="background: #42B574;"></div>
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button @click="slide = 1" class="flex-1 py-3 px-6 rounded-xl font-medium text-sm transition-all duration-200 border" style="font-family: 'Manrope', sans-serif; color: #4B5563; border-color: #D1D5DB;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                            ← Retour
                        </button>
                        <button @click="slide = 3" class="flex-1 py-3 px-6 rounded-xl text-white font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            Suivant →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slide 3: Connectez --}}
            <div x-show="slide === 3" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="pt-10 pb-6 px-8 text-center">
                    {{-- Icon --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center" style="background: #EFF6FF;">
                        <svg class="w-10 h-10" fill="none" stroke="#4A7FBF" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-semibold mb-3" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                        Connectez en personne
                    </h2>
                    <p class="text-sm leading-relaxed mb-8" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                        Commandez votre carte NFC et partagez votre profil d'un <strong>simple geste</strong>. Votre réseau professionnel se construit naturellement.
                    </p>

                    {{-- Dots --}}
                    <div class="flex items-center justify-center space-x-2 mb-6">
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                        <div class="w-2 h-2 rounded-full" style="background: #D1D5DB;"></div>
                        <div class="w-2.5 h-2.5 rounded-full" style="background: #42B574;"></div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button @click="slide = 2" class="flex-1 py-3 px-6 rounded-xl font-medium text-sm transition-all duration-200 border" style="font-family: 'Manrope', sans-serif; color: #4B5563; border-color: #D1D5DB;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                            ← Retour
                        </button>
                        <button @click="$wire.closeModal()" class="flex-1 py-3 px-6 rounded-xl text-white font-medium text-sm transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'" onmouseout="this.style.background='#42B574'">
                            Commencer!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ═══════════════════════════════════════ --}}
        {{-- ONBOARDING CHECKLIST --}}
        {{-- ═══════════════════════════════════════ --}}
        @if($showChecklist && !$onboardingComplete)
        <div class="mb-6 bg-white rounded-xl border overflow-hidden" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);" wire:key="onboarding-checklist">
            <div class="p-4 sm:p-6">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-4 h-4" fill="none" stroke="#42B574" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.841m2.699-2.102l-2.818 2.818"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                                Complétez votre profil
                            </h3>
                            <p class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                                {{ collect($onboardingSteps)->where('completed', true)->count() }}/{{ count($onboardingSteps) }} étapes
                            </p>
                        </div>
                    </div>
                    <button wire:click="dismissChecklist" class="text-xs px-3 py-1.5 rounded-lg transition-colors" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;" onmouseover="this.style.background='#F3F4F6'" onmouseout="this.style.background='transparent'">
                        Masquer
                    </button>
                </div>

                {{-- Progress bar --}}
                <div class="w-full h-2 rounded-full mb-4" style="background: #E5E7EB;">
                    <div class="h-2 rounded-full transition-all duration-500" style="background: linear-gradient(90deg, #42B574, #4A7FBF); width: {{ $onboardingProgress }}%;"></div>
                </div>

                {{-- Steps --}}
                <div class="space-y-2">
                    @foreach($onboardingSteps as $step)
                        <div class="flex items-center justify-between py-2 px-3 rounded-lg {{ $step['completed'] ? '' : 'cursor-pointer' }}"
                             style="{{ $step['completed'] ? 'background: #F0F9F4;' : '' }}"
                             @if(!$step['completed'] && $step['action'])
                                 onclick="window.location.href='{{ $step['action'] }}'"
                                 onmouseover="this.style.background='#F3F4F6'"
                                 onmouseout="this.style.background='{{ $step['completed'] ? '#F0F9F4' : 'transparent' }}'"
                             @endif
                        >
                            <div class="flex items-center space-x-3">
                                @if($step['completed'])
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: #42B574;">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 rounded-full border-2 flex-shrink-0" style="border-color: #D1D5DB;"></div>
                                @endif
                                <span class="text-sm {{ $step['completed'] ? 'line-through' : '' }}" style="font-family: 'Manrope', sans-serif; color: {{ $step['completed'] ? '#9CA3AF' : '#2C2A27' }};">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                            @if(!$step['completed'] && $step['action'])
                                <svg class="w-4 h-4 flex-shrink-0" style="color: #9CA3AF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ═══════════════════════════════════════ --}}
        {{-- EXISTING DASHBOARD CONTENT --}}
        {{-- ═══════════════════════════════════════ --}}

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">
                Bienvenue, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="mt-2 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                Ravi de vous revoir sur Link-Card. Voici un aperçu de votre compte.
            </p>
        </div>

        <div class="flex flex-col">

        <!-- Stats Cards (EN SECOND sur mobile, EN PREMIER sur desktop) -->
        <div class="grid gap-3 sm:gap-6 mb-6 sm:mb-8 grid-cols-2 xl:grid-cols-4 order-last lg:order-first">

            <!-- Plan Actuel -->
            <div class="bg-white rounded-xl border p-4 sm:p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Forfait</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #EFF6FF;">
                        <svg class="w-5 h-5" fill="none" stroke="#4A7FBF" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ ((Auth::user()->plan ?? 'free') === 'free') ? 'GRATUIT' : strtoupper(Auth::user()->plan) }}
                </p>
            </div>

            <!-- Profils -->
            <div class="bg-white rounded-xl border p-4 sm:p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Profils</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="none" stroke="#42B574" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ Auth::user()->profiles->count() }}
                </p>
            </div>

            <!-- Cartes NFC -->
            <div class="bg-white rounded-xl border p-4 sm:p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Cartes NFC</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #F3F0FF;">
                        <svg class="w-5 h-5" fill="none" stroke="#8B5CF6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">{{ Auth::user()->cards->count() }}</p>
            </div>

            <!-- Vues Totales -->
            <div class="bg-white rounded-xl border p-4 sm:p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Vues Totales</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #FFF1F2;">
                        <svg class="w-5 h-5" fill="none" stroke="#E11D48" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ Auth::user()->profiles->sum('view_count') }}
                </p>
            </div>
        </div>

        <!-- Actions Rapides (EN PREMIER sur mobile, EN SECOND sur desktop) -->
        <div class="bg-white rounded-xl border p-4 sm:p-6 order-first lg:order-last" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h2 class="text-lg font-semibold mb-4" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Actions Rapides</h2>
            <div class="grid gap-4 md:grid-cols-2">

                @php
                    $profileCount = Auth::user()->profiles->count();
                    $firstProfile = Auth::user()->profiles->first();
                @endphp

                @if($profileCount === 0)
                    <!-- Aucun profil - Créer -->
                    <a href="{{ route('profile.create') }}"
                       class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                       style="border-color: #D1D5DB;"
                       onmouseover="this.style.borderColor='#42B574'; this.style.background='#F0F9F4'"
                       onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-6 h-6" fill="#42B574" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Créer mon profil</p>
                            <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nouveau profil Link-Card</p>
                        </div>
                    </a>
                @elseif($profileCount === 1)
                    <!-- Un seul profil - Modifier directement -->
                    <a href="{{ route('profile.edit', $firstProfile) }}"
                       class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                       style="border-color: #D1D5DB;"
                       onmouseover="this.style.borderColor='#42B574'; this.style.background='#F0F9F4'"
                       onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-6 h-6" fill="#42B574" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Modifier mon profil</p>
                            <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $firstProfile->full_name }}</p>
                        </div>
                    </a>
                @else
                    <!-- Plusieurs profils - Voir la liste -->
                    <a href="{{ route('profile.index') }}"
                       class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                       style="border-color: #D1D5DB;"
                       onmouseover="this.style.borderColor='#42B574'; this.style.background='#F0F9F4'"
                       onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                            <svg class="w-6 h-6" fill="#42B574" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Mes profils</p>
                            <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">{{ $profileCount }} profils</p>
                        </div>
                    </a>
                @endif

                <a href="{{ route('cards.order') }}"
                   class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                   style="border-color: #D1D5DB;"
                   onmouseover="this.style.borderColor='#4A7FBF'; this.style.background='#EFF6FF'"
                   onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #EFF6FF;">
                        <svg class="w-6 h-6" fill="#4A7FBF" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Commander une carte</p>
                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Carte NFC physique</p>
                    </div>
                </a>
            </div>
        </div>

        </div> {{-- end flex col wrapper --}}
    </div>
</div>
