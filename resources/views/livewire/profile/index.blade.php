<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Profils</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $profileCount }}/{{ $profileLimit }} 
                        @if($userPlan === 'free')
                            profil utilisé
                        @else
                            profils utilisés
                        @endif
                    </p>
                </div>
                
                @if($canCreateMore)
                    <a href="{{ route('profile.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer un profil
                    </a>
                @endif
            </div>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if (session()->has('info'))
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            </div>
        @endif

        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-blue-800">
                Plan: {{ strtoupper($userPlan) }}
                @if($userPlan === 'free')
                    (1 profil maximum)
                @else
                    ({{ $profileLimit }} profils disponibles)
                @endif
            </h3>
        </div>

        @if($profiles->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($profiles as $profile)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $profile->full_name }}</h3>
                        @if($profile->job_title)
                            <p class="text-sm text-gray-600">{{ $profile->job_title }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun profil</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par créer votre premier profil.</p>
                @if($canCreateMore)
                    <div class="mt-6">
                        <a href="{{ route('profile.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Créer mon premier profil
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
