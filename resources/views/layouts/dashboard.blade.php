<!DOCTYPE html>
<html lang="fr">
<head>
    <style>[x-cloak] { display: none !important; }</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Link-Card</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    @livewireStyles
</head>
<body style="font-family: 'Manrope', system-ui, sans-serif; background-color: #F7F8F4; overflow: hidden; height: 100dvh;" x-data="{ sidebarOpen: false }">

    {{-- Mobile top bar --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3" style="background-color: #2C2A27;">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-blanc.png') }}" alt="Link-Card" class="h-8 w-auto">
            <span class="text-white font-semibold">Link-Card</span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-white p-2">
            <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="sidebarOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="lg:hidden fixed inset-0 z-40 bg-black bg-opacity-50 transition-opacity"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="fixed lg:static inset-y-0 left-0 z-50 w-64 flex flex-col transform transition-transform duration-200 ease-in-out lg:transform-none"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               style="background-color: #2C2A27;">
            <div class="p-6 border-b" style="border-color: rgba(255,255,255,0.1);">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-blanc.png') }}" alt="Link-Card" class="h-9 w-auto">
                    <span class="text-white font-semibold text-lg">Link-Card</span>
                </div>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>

                <a href="{{ route('profile.index') }}"
                   class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mes Profils
                </a>

                <a href="{{ route('cards.index') }}"
                   class="sidebar-link {{ request()->routeIs('cards.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Mes Cartes
                </a>

                <a href="{{ route('connections.index') }}"
                   class="sidebar-link {{ request()->routeIs('connections.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                    Mes Connexions
                    @if(Auth::user()->pending_connections_count > 0)
                        <span class="ml-auto w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #EF4444;">
                            {{ Auth::user()->pending_connections_count }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('subscription.plans') }}"
                   class="sidebar-link {{ request()->routeIs('subscription.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Abonnement
                </a>

                @if(Auth::user()->isAdmin())
                    <div class="my-3" style="border-top: 1px solid rgba(255,255,255,0.1);"></div>
                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Administration
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t" style="border-color: rgba(255,255,255,0.1);">
                <div class="flex items-center px-3 py-2.5 rounded-lg" style="background: rgba(255,255,255,0.05);">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold text-white flex-shrink-0" style="background-color: #42B574;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs truncate" style="color: rgba(255,255,255,0.45);">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="mt-2 space-y-0.5">
                    <a href="{{ route('preferences.index') }}"
                       class="block px-3 py-2 text-sm rounded-lg transition {{ request()->routeIs('preferences.*') ? '' : '' }}"
                       style="color: rgba(255,255,255,0.6);"
                       onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        ⚙️ Préférences
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color: rgba(255,255,255,0.6);"
                                onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                                onmouseout="this.style.background='transparent'">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 overflow-y-auto pt-14 lg:pt-0" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
