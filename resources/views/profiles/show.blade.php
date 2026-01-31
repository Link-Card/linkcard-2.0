<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->full_name }} - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden">
            
            <!-- Header avec dégradé -->
            <div class="relative h-48" style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%);">
                <!-- Photo profil centrée en bas -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    @if($profile->photo_path)
                        <img src="{{ asset('storage/' . $profile->photo_path) }}" 
                             alt="{{ $profile->full_name }}"
                             class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center text-4xl font-bold text-gray-600 shadow-lg">
                            {{ strtoupper(substr($profile->full_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contenu -->
            <div class="pt-20 px-6 pb-6 text-center">
                <!-- Nom et infos -->
                <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $profile->full_name }}</h1>
                
                @if($profile->job_title)
                    <p class="text-gray-600 font-medium">{{ $profile->job_title }}</p>
                @endif
                
                @if($profile->company)
                    <p class="text-gray-500">{{ $profile->company }}</p>
                @endif
                
                @if($profile->location)
                    <p class="text-gray-500 flex items-center justify-center gap-1 mt-1">
                        📍 {{ $profile->location }}
                    </p>
                @endif

                <!-- Bouton Ajouter aux contacts -->
                <button class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2">
                    ➕ Ajouter aux contacts
                </button>

                <!-- Bio -->
                @if($profile->bio)
                    <div class="mt-6 text-left">
                        <p class="text-gray-700 leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                @endif

                <!-- Contacts (email, phone, website) -->
                @if($profile->email || $profile->phone || $profile->website)
                    <div class="mt-6 space-y-3 text-left">
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" 
                               class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <span class="text-xl">✉️</span>
                                <span>{{ $profile->email }}</span>
                            </a>
                        @endif

                        @if($profile->phone)
                            <a href="tel:{{ $profile->phone }}" 
                               class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <span class="text-xl">📞</span>
                                <span>{{ $profile->phone }}</span>
                            </a>
                        @endif

                        @if($profile->website)
                            <a href="{{ $profile->website }}" target="_blank"
                               class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <span class="text-xl">🌐</span>
                                <span class="truncate">Site web</span>
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Liens sociaux -->
                @if($profile->links->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 text-left">Réseaux sociaux</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($profile->links as $link)
                                <a href="{{ $link->url }}" target="_blank"
                                   class="flex items-center gap-2 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                    <span class="text-2xl">{{ \App\Models\Link::getPlatformIcon($link->platform) }}</span>
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ $link->platform }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Galerie d'images -->
                @if($profile->galleryItems->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 text-left">Galerie</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($profile->galleryItems as $item)
                                <img src="{{ asset('storage/' . $item->path) }}" 
                                     alt="Galerie"
                                     class="w-full h-48 object-contain bg-gray-50 rounded-lg shadow">
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-400">
                        Créé avec 💚 sur <a href="https://linkcard.ca" class="text-green-600 hover:underline">Link-Card</a>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $profile->view_count }} vues</p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
