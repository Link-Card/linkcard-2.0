<div>
    <!-- Message de bienvenue -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">
            Bienvenue, {{ auth()->user()->name }}! 👋
        </h3>
        <p class="text-gray-600">
            Ravi de vous revoir sur Link-Card. Voici un aperçu de votre compte.
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Plan -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-medium text-gray-500">Plan Actuel</h4>
                    <p class="text-2xl font-bold text-gray-900 uppercase">{{ $stats['plan'] }}</p>
                </div>
            </div>
        </div>

        <!-- Profils -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-medium text-gray-500">Profils</h4>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['profiles'] }}</p>
                </div>
            </div>
        </div>

        <!-- Cartes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-medium text-gray-500">Cartes NFC</h4>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['cards'] }}</p>
                </div>
            </div>
        </div>

        <!-- Vues -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-medium text-gray-500">Vues Totales</h4>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['views'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">Créer un profil</p>
                    <p class="text-sm text-gray-500">Nouveau profil Link-Card</p>
                </div>
            </a>
            
            <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">Commander une carte</p>
                    <p class="text-sm text-gray-500">Carte NFC physique</p>
                </div>
            </a>
            
            @if($stats['plan'] === 'free')
            <a href="#" class="flex items-center p-4 border border-indigo-200 bg-indigo-50 rounded-lg hover:bg-indigo-100">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                </svg>
                <div>
                    <p class="font-medium text-indigo-900">Passer à PRO</p>
                    <p class="text-sm text-indigo-700">Débloquer plus de fonctionnalités</p>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>
