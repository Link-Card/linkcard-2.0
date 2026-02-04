<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Link-Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Favicon Link-Card -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Manrope Font (Brand Book) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    @livewireStyles
</head>
<body style="font-family: 'Manrope', system-ui, sans-serif; background-color: #F7F8F4;">
    <div class="flex h-screen">
        <!-- Sidebar - Gris premium Brand Book -->
        <aside class="w-64 flex flex-col" style="background-color: #2C2A27;">

            <!-- Logo -->
            <div class="p-6 border-b" style="border-color: rgba(255,255,255,0.1);">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-blanc.png') }}" alt="Link-Card" class="h-9 w-auto"><span class="text-white font-semibold text-lg ml-3">Link-Card</span>
                    <div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-5 space-y-1">
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

                <a href="#"
                   class="sidebar-link">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Abonnement
                </a>
            </nav>

            <!-- User section -->
            <div class="p-4 border-t" style="border-color: rgba(255,255,255,0.1);">
                <div class="flex items-center px-3 py-2.5 rounded-lg" style="background: rgba(255,255,255,0.05);">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold text-white" style="background-color: #42B574;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs truncate" style="color: rgba(255,255,255,0.45);">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="mt-2 space-y-0.5">
                    <a href="#"
                       class="block px-3 py-2 text-sm rounded-lg transition" style="color: rgba(255,255,255,0.6);"
                       onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                       onmouseout="this.style.background='transparent'">
                        Paramètres
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-3 py-2 text-sm rounded-lg transition" style="color: rgba(255,255,255,0.6);"
                                onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                                onmouseout="this.style.background='transparent'">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
