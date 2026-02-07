<div class="py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">
                Bienvenue, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                Voici un aperçu de votre compte.
            </p>
        </div>

        <div class="flex flex-col">

        <!-- Actions Rapides (EN PREMIER sur mobile, EN SECOND sur desktop) -->
        <div class="grid grid-cols-2 gap-3 mb-6 order-first lg:order-last">
            @php
                $profileCount = Auth::user()->profiles->count();
                $firstProfile = Auth::user()->profiles->first();
            @endphp

            @if($profileCount === 0)
                <a href="{{ route('profile.create') }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
                   style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    </div>
                    <span class="text-xs font-medium" style="color: #2C2A27;">Créer mon profil</span>
                </a>
            @elseif($profileCount === 1)
                <a href="{{ route('profile.edit', $firstProfile) }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
                   style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                    </div>
                    <span class="text-xs font-medium" style="color: #2C2A27;">Modifier profil</span>
                </a>
            @else
                <a href="{{ route('profile.index') }}"
                   class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
                   style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="#42B574" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <span class="text-xs font-medium" style="color: #2C2A27;">Mes profils</span>
                </a>
            @endif

            <a href="{{ route('cards.order') }}"
               class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
               style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #EFF6FF;">
                    <svg class="w-5 h-5" fill="#4A7FBF" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                </div>
                <span class="text-xs font-medium" style="color: #2C2A27;">Commander carte</span>
            </a>

            <a href="{{ route('cards.index') }}"
               class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
               style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #F3F0FF;">
                    <svg class="w-5 h-5" fill="none" stroke="#8B5CF6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                </div>
                <span class="text-xs font-medium" style="color: #2C2A27;">Mes cartes</span>
            </a>

            <a href="{{ route('subscription.plans') }}"
               class="flex flex-col items-center p-4 rounded-xl bg-white border transition-all text-center"
               style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2" style="background: #FFF1F2;">
                    <svg class="w-5 h-5" fill="none" stroke="#E11D48" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium" style="color: #2C2A27;">Abonnement</span>
            </a>
        </div>

        <!-- Stats Cards (EN SECOND sur mobile, EN PREMIER sur desktop) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 order-last lg:order-first mb-6 lg:mb-6">
            <div class="bg-white rounded-xl border p-4" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <p class="text-xs mb-1" style="color: #4B5563;">Plan</p>
                <p class="text-lg font-semibold" style="color: #2C2A27;">
                    {{ ((Auth::user()->plan ?? 'free') === 'free') ? 'GRATUIT' : strtoupper(Auth::user()->plan) }}
                </p>
            </div>
            <div class="bg-white rounded-xl border p-4" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <p class="text-xs mb-1" style="color: #4B5563;">Profils</p>
                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ Auth::user()->profiles->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border p-4" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <p class="text-xs mb-1" style="color: #4B5563;">Cartes NFC</p>
                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ Auth::user()->cards->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border p-4" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <p class="text-xs mb-1" style="color: #4B5563;">Vues</p>
                <p class="text-lg font-semibold" style="color: #2C2A27;">{{ Auth::user()->profiles->sum('view_count') }}</p>
            </div>
        </div>

        </div> {{-- end flex col wrapper --}}
    </div>
</div>
