<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->full_name }} - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Header avec dégradé -->
            <div class="h-40 relative" 
                 style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%)">
            </div>
            
            <!-- Photo de profil -->
            <div class="px-6 pb-6">
                <div class="flex justify-center -mt-20 mb-4">
                    @if($profile->photo_path)
                        <img src="{{ Storage::url($profile->photo_path) }}" 
                             alt="{{ $profile->full_name }}"
                             class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-300 flex items-center justify-center shadow-lg">
                            <span class="text-4xl font-bold text-gray-600">
                                {{ substr($profile->full_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Informations -->
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $profile->full_name }}</h1>
                    
                    @if($profile->job_title)
                        <p class="text-gray-600 mb-1">{{ $profile->job_title }}</p>
                    @endif
                    
                    @if($profile->company)
                        <p class="text-sm text-gray-500 mb-1">{{ $profile->company }}</p>
                    @endif
                    
                    @if($profile->location)
                        <p class="text-sm text-gray-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $profile->location }}
                        </p>
                    @endif
                </div>
                
                <!-- Bouton Ajouter aux contacts -->
                <div class="mb-6">
                    <a href="#" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-md transition duration-150">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter aux contacts
                    </a>
                </div>
                
                <!-- Bio -->
                @if($profile->bio)
                    <div class="mb-6">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                @endif
                
                <!-- Coordonnées -->
                @if($profile->email || $profile->phone || $profile->website)
                    <div class="border-t border-gray-200 pt-6 mb-6 space-y-3">
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" 
                               class="flex items-center text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">{{ $profile->email }}</span>
                            </a>
                        @endif
                        
                        @if($profile->phone)
                            <a href="tel:{{ $profile->phone }}" 
                               class="flex items-center text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-sm">{{ $profile->phone }}</span>
                            </a>
                        @endif
                        
                        @if($profile->website)
                            <a href="{{ $profile->website }}" 
                               target="_blank"
                               class="flex items-center text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span class="text-sm">Site web</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Créé avec <span class="text-green-600">♥</span> sur 
                    <a href="https://linkcard.ca" class="text-green-600 hover:text-green-700 font-medium">Link-Card</a>
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $profile->view_count }} vues</p>
            </div>
        </div>
    </div>
</body>
</html>
