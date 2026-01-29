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
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 overflow-hidden border border-gray-200">
                        <div class="relative h-32 bg-gradient-to-br" style="background: linear-gradient(135deg, {{ $profile->primary_color ?? '#2D7A4F' }} 0%, {{ $profile->primary_color ?? '#2D7A4F' }}dd 100%)">
                            @if($profile->photo_path)
                                <img src="{{ Storage::url($profile->photo_path) }}" 
                                     alt="{{ $profile->full_name }}"
                                     class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white object-cover shadow-lg">
                            @else
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-24 h-24 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-gray-600">
                                        {{ substr($profile->full_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-14 px-6 pb-6">
                            <div class="text-center mb-4">
                                <h3 class="text-lg font-bold text-gray-900">{{ $profile->full_name }}</h3>
                                @if($profile->job_title)
                                    <p class="text-sm text-gray-600">{{ $profile->job_title }}</p>
                                @endif
                                @if($profile->company)
                                    <p class="text-xs text-gray-500 mt-1">{{ $profile->company }}</p>
                                @endif
                            </div>

                            <!-- Code profil -->
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Code profil:</p>
                                <p class="text-sm font-mono font-bold text-gray-900">{{ $profile->username }}</p>
                                <p class="text-xs text-gray-500 mt-1">app.linkcard.ca/{{ $profile->username }}</p>
                            </div>

                            <div class="flex justify-center items-center mb-4 text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>{{ $profile->view_count ?? 0 }} vues</span>
                            </div>

                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('profile.public', $profile->username) }}" 
                                   target="_blank"
                                   class="w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Voir public
                                </a>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('profile.edit', $profile->id) }}" 
                                       class="flex-1 text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-150">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Modifier
                                    </a>
                                    
                                    <button wire:click="deleteProfile({{ $profile->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce profil? Cette action est irréversible."
                                            class="flex-1 text-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-150">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
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

        @if(!$canCreateMore)
            <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Limite atteinte ({{ $profileCount }}/{{ $profileLimit }})
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Vous avez atteint la limite de profils pour votre plan {{ strtoupper($userPlan) }}.</p>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-3">
                            @if($userPlan === 'free')
                                <a href="{{ route('pricing') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                    Passer à PRO (5$/mois)
                                </a>
                                <button wire:click="$dispatch('open-request-modal')"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Demander profil additionnel
                                </button>
                            @else
                                <a href="{{ route('profile.add-additional') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Acheter profils additionnels
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
