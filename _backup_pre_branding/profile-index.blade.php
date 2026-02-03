<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Mes Profils</h2>
        
        @if($canCreateMore)
            <a href="{{ route('profile.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                + Créer un profil
            </a>
        @else
            <button disabled 
                    class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                Limite atteinte
            </button>
        @endif
    </div>

    <div class="mb-4 text-sm text-gray-600">
        <span class="font-medium">{{ $profilesCount }}/{{ $maxProfiles }}</span> profils utilisés
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($profiles->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun profil</h3>
            <p class="mt-1 text-gray-500">Créez votre premier profil pour commencer.</p>
            <div class="mt-6">
                <a href="{{ route('profile.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium inline-block">
                    Créer mon premier profil
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($profiles as $profile)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Header avec dégradé -->
                    <div class="h-32" style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%);">
                        <div class="flex justify-center items-end h-full pb-4">
                            @if($profile->photo_path)
                                <img src="{{ Storage::url($profile->photo_path) }}" 
                                     alt="{{ $profile->full_name }}"
                                     class="w-24 h-24 rounded-full border-4 border-white object-cover">
                            @else
                                <div class="w-24 h-24 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-600">
                                    {{ strtoupper(substr($profile->full_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $profile->full_name }}</h3>
                        @if($profile->job_title)
                            <p class="text-gray-600">{{ $profile->job_title }}</p>
                        @endif
                        @if($profile->company)
                            <p class="text-gray-500 text-sm">{{ $profile->company }}</p>
                        @endif

                        <div class="mt-3 text-sm text-gray-500">
                            <div class="font-mono">Code: {{ $profile->username }}</div>
                            <div>Vues: {{ $profile->view_count }}</div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 space-y-2">
                            <a href="{{ route('profile.public', $profile->username) }}" 
                               target="_blank"
                               class="block text-center bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded font-medium">
                                👁️ Voir public
                            </a>

                            <a href="{{ route('profile.qr.download', $profile) }}" 
                               class="block text-center bg-purple-100 hover:bg-purple-200 text-purple-700 px-4 py-2 rounded font-medium">
                                📥 Télécharger QR Code
                            </a>

                            <a href="{{ route('profile.edit', $profile) }}" 
                               class="block text-center bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded font-medium">
                                ✏️ Modifier
                            </a>

                            <button wire:click="delete({{ $profile->id }})" 
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer ce profil ?"
                                    class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded font-medium">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
