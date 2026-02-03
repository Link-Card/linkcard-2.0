<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->full_name }} - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    
    <div class="max-w-2xl mx-auto">
        
        <!-- Header avec dégradé + toutes les infos -->
        <div class="relative" style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%);">
            <div class="px-6 pt-12 pb-8 text-white">
                
                <!-- Photo -->
                <div class="flex justify-center mb-6">
                    @if($profile->photo_path)
                        <img src="{{ Storage::url($profile->photo_path) }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-full bg-white/30 border-4 border-white shadow-xl flex items-center justify-center">
                            <span class="text-5xl">👤</span>
                        </div>
                    @endif
                </div>
                
                <!-- Nom + Titre -->
                <h1 class="text-3xl font-bold text-center mb-2">{{ $profile->full_name }}</h1>
                
                @if($profile->job_title)
                    <p class="text-lg text-center text-white/90">{{ $profile->job_title }}</p>
                @endif
                
                @if($profile->company)
                    <p class="text-base text-center text-white/80 mt-1">{{ $profile->company }}</p>
                @endif
                
                @if($profile->location)
                    <p class="text-sm text-center text-white/75 mt-3 flex items-center justify-center">
                        <span class="mr-1">📍</span> {{ $profile->location }}
                    </p>
                @endif
                
                <!-- Infos de contact dans le header -->
                <div class="mt-6 space-y-2">
                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}" 
                           class="flex items-center justify-center space-x-2 text-white/90 hover:text-white">
                            <span class="text-lg">📞</span>
                            <span class="text-sm">{{ $profile->phone }}</span>
                        </a>
                    @endif
                    
                    @if($profile->email)
                        <a href="mailto:{{ $profile->email }}" 
                           class="flex items-center justify-center space-x-2 text-white/90 hover:text-white">
                            <span class="text-lg">✉️</span>
                            <span class="text-sm">{{ $profile->email }}</span>
                        </a>
                    @endif
                    
                    @if($profile->website)
                        <a href="{{ $profile->website }}" target="_blank"
                           class="flex items-center justify-center space-x-2 text-white/90 hover:text-white">
                            <span class="text-lg">🌐</span>
                            <span class="text-sm truncate max-w-xs">{{ $profile->website }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contenu - ContentBands -->
        <div class="bg-white shadow-lg rounded-b-3xl">
            <div class="px-6 py-8 space-y-4">
                
                @foreach($profile->contentBands as $band)
                    
                    @if($band->type === 'contact_button')
                        <!-- Bouton vCard -->
                        <a href="{{ route('profile.vcard', $profile) }}" 
                           class="block w-full py-4 px-6 bg-green-600 hover:bg-green-700 text-white text-center rounded-xl font-semibold shadow-md transition">
                            📇 Ajouter aux contacts
                        </a>
                    
                    @elseif($band->type === 'social_link')
                        <!-- Lien social avec icône + nom -->
                        <a href="{{ $band->data['url'] }}" target="_blank"
                           class="block p-4 bg-gray-50 hover:bg-gray-100 rounded-xl border border-gray-200 transition">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-2xl">
                                    @if($band->data['platform'] === 'Facebook')
                                        <i class="fab fa-facebook" style="color: #1877F2;"></i>
                                    @elseif($band->data['platform'] === 'Instagram')
                                        <i class="fab fa-instagram" style="color: #E4405F;"></i>
                                    @elseif($band->data['platform'] === 'LinkedIn')
                                        <i class="fab fa-linkedin" style="color: #0A66C2;"></i>
                                    @elseif($band->data['platform'] === 'Twitter')
                                        <i class="fab fa-twitter" style="color: #1DA1F2;"></i>
                                    @elseif($band->data['platform'] === 'TikTok')
                                        <i class="fab fa-tiktok" style="color: #000000;"></i>
                                    @elseif($band->data['platform'] === 'YouTube')
                                        <i class="fab fa-youtube" style="color: #FF0000;"></i>
                                    @elseif($band->data['platform'] === 'GitHub')
                                        <i class="fab fa-github" style="color: #181717;"></i>
                                    @else
                                        <i class="fas fa-link" style="color: #6B7280;"></i>
                                    @endif
                                </div>
                                <span class="font-medium text-gray-900">{{ $band->data['platform'] }}</span>
                            </div>
                        </a>
                    
                    @elseif($band->type === 'image')
                        <!-- Image taille contrôlée -->
                        <div class="rounded-xl overflow-hidden shadow-md">
                            @if(isset($band->data['link']) && $band->data['link'])
                                <a href="{{ $band->data['link'] }}" target="_blank">
                                    <img src="{{ Storage::url($band->data['path']) }}" 
                                         class="w-full h-auto object-contain max-h-80 hover:opacity-90 transition">
                                </a>
                            @else
                                <img src="{{ Storage::url($band->data['path']) }}" 
                                     class="w-full h-auto object-contain max-h-80">
                            @endif
                        </div>
                    
                    @elseif($band->type === 'text_block')
                        <!-- Bloc de texte -->
                        <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $band->data['text'] }}</p>
                        </div>
                    
                    @endif
                    
                @endforeach
            </div>
            
            <!-- Footer -->
            <div class="px-6 pb-8 pt-4 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-500">
                    Propulsé par 
                    <a href="https://linkcard.ca" target="_blank" class="text-green-600 hover:text-green-700 font-semibold">
                        Link-Card
                    </a>
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    {{ $profile->view_count }} vues
                </p>
            </div>
        </div>
    </div>
    
</body>
</html>
