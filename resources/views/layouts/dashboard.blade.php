<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Link-Card</title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>

    @livewireStyles
</head>
<body style="background-color: #F7F8F4;">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 flex flex-col" style="background-color: #2C2A27;">
            {{-- Logo --}}
            <div class="p-6" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="flex items-center space-x-3">
                    <img src="/images/logo-blanc.png" alt="Link-Card" class="h-8" onerror="this.style.display='none'">
                    <div>
                        <h1 class="text-lg font-bold text-white">Link-Card</h1>
                        <p class="text-xs" style="color: #9CA3AF;">Dashboard</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition"
                   style="{{ request()->routeIs('dashboard') ? 'background-color: #42B574; color: #FFFFFF;' : 'color: #D1D5DB;' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-sm font-medium">Tableau de bord</span>
                </a>

                <a href="{{ route('profile.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition"
                   style="{{ request()->routeIs('profile.*') ? 'background-color: #42B574; color: #FFFFFF;' : 'color: #D1D5DB;' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium">Mes Profils</span>
                </a>

                <a href="{{ route('cards.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition"
                   style="{{ request()->routeIs('cards.*') ? 'background-color: #42B574; color: #FFFFFF;' : 'color: #D1D5DB;' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span class="text-sm font-medium">Mes Cartes</span>
                </a>

                <a href="{{ route('subscription.plans') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition"
                   style="{{ request()->routeIs('subscription.*') ? 'background-color: #42B574; color: #FFFFFF;' : 'color: #D1D5DB;' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">Abonnement</span>
                </a>
            </nav>

            {{-- User section --}}
            <div class="p-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="flex items-center px-4 py-3 rounded-lg">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: #42B574;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 text-left">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs" style="color: #9CA3AF;">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="mt-2 space-y-1">
                    <a href="#"
                       class="block px-4 py-2 text-sm rounded-lg transition"
                       style="color: #9CA3AF;">
                        Paramètres
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm rounded-lg transition"
                                style="color: #9CA3AF;">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
