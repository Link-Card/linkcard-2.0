<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Link-Card</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <aside class="w-64 bg-indigo-800 text-white flex flex-col">
            <div class="p-6 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">Link-Card</h1>
                <p class="text-sm text-indigo-200 mt-1">Dashboard</p>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>
                
                <a href="{{ route('profile.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-indigo-900 text-white' : 'text-indigo-100 hover:bg-indigo-700' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mes Profils
                </a>
                
                <a href="#" 
                   class="flex items-center px-4 py-3 rounded-lg text-indigo-100 hover:bg-indigo-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Abonnement
                </a>
            </nav>
            
            <div class="border-t border-indigo-700 p-4" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3 text-left">
                            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-200">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-indigo-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div x-show="open" 
                     x-transition
                     @click.away="open = false"
                     class="mt-2 space-y-1">
                    <a href="#" 
                       class="block px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-700 rounded-lg transition">
                        Paramètres
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-4 py-2 text-sm text-indigo-100 hover:bg-indigo-700 rounded-lg transition">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>
    
    @livewireScripts
</body>
</html>
