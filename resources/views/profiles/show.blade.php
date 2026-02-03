<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->full_name }} - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <div class="max-w-2xl mx-auto">
        
        <!-- Header avec dégradé -->
        <div class="relative" style="background: linear-gradient(135deg, {{ $profile->primary_color }} 0%, {{ $profile->primary_color }}dd 100%);">
            <div class="h-48 flex flex-col items-center justify-center text-white px-6 pb-16">
                @if($profile->photo_path)
                    <img src="{{ Storage::url($profile->photo_path) }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl mb-4">
                @else
                    <div class="w-32 h-32 rounded-full bg-white/30 border-4 border-white shadow-xl mb-4 flex items-center justify-center">
                        <span class="text-5xl">👤</span>
                    </div>
                @endif
                
                <h1 class="text-3xl font-bold text-center">{{ $profile->full_name }}</h1>
                
                @if($profile->job_title)
                    <p class="text-lg text-white/90 mt-2">{{ $profile->job_title }}</p>
                @endif
                
                @if($profile->company)
                    <p class="text-base text-white/80 mt-1">{{ $profile->company }}</p>
                @endif
                
                @if($profile->location)
                    <p class="text-sm text-white/70 mt-2 flex items-center">
                        <span class="mr-1">📍</span> {{ $profile->location }}
                    </p>
                @endif
            </div>
        </div>
        
        <!-- Contenu -->
        <div class="bg-white shadow-lg -mt-8 rounded-t-3xl relative z-10">
            <div class="px-6 py-8 space-y-4">
                
                <!-- Infos de contact -->
                @if($profile->phone)
                    <div class="flex items-center space-x-3 text-gray-700">
                        <span class="text-2xl">📞</span>
                        <a href="tel:{{ $profile->phone }}" class="hover:text-green-600">{{ $profile->phone }}</a>
                    </div>
                @endif
                
                @if($profile->email)
                    <div class="flex items-center space-x-3 text-gray-700">
                        <span class="text-2xl">✉️</span>
                        <a href="mailto:{{ $profile->email }}" class="hover:text-green-600">{{ $profile->email }}</a>
                    </div>
                @endif
                
                @if($profile->website)
                    <div class="flex items-center space-x-3 text-gray-700">
                        <span class="text-2xl">🌐</span>
                        <a href="{{ $profile->website }}" target="_blank" class="hover:text-green-600 truncate">{{ $profile->website }}</a>
                    </div>
                @endif
                
                <!-- ContentBands -->
                @foreach($profile->contentBands as $band)
                    
                    @if($band->type === 'contact_button')
                        <!-- Bouton vCard -->
                        <a href="{{ route('profile.vcard', $profile) }}" 
                           class="block w-full py-4 px-6 bg-green-600 hover:bg-green-700 text-white text-center rounded-xl font-semibold shadow-md transition">
                            📇 Ajouter aux contacts
                        </a>
                    
                    @elseif($band->type === 'social_link')
                        <!-- Lien social -->
                        <a href="{{ $band->data['url'] }}" target="_blank"
                           class="block p-4 bg-gray-50 hover:bg-gray-100 rounded-xl border border-gray-200 transition">
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl">
                                    @if($band->data['platform'] === 'Facebook') 🔵
                                    @elseif($band->data['platform'] === 'Instagram') 📷
                                    @elseif($band->data['platform'] === 'LinkedIn') 💼
                                    @elseif($band->data['platform'] === 'Twitter') 🐦
                                    @elseif($band->data['platform'] === 'TikTok') 🎵
                                    @elseif($band->data['platform'] === 'YouTube') ▶️
                                    @elseif($band->data['platform'] === 'GitHub') 💻
                                    @else 🔗
                                    @endif
                                </span>
                                <span class="font-medium text-gray-900">{{ $band->data['platform'] }}</span>
                            </div>
                        </a>
                    
                    @elseif($band->type === 'image')
                        <!-- Image -->
                        <div class="rounded-xl overflow-hidden shadow-md">
                            @if(isset($band->data['link']) && $band->data['link'])
                                <a href="{{ $band->data['link'] }}" target="_blank">
                                    <img src="{{ Storage::url($band->data['path']) }}" 
                                         class="w-full h-auto max-h-96 object-cover hover:opacity-90 transition">
                                </a>
                            @else
                                <img src="{{ Storage::url($band->data['path']) }}" 
                                     class="w-full h-auto max-h-96 object-cover">
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
