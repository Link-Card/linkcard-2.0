<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title>Activer ma carte - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #F7F8F4;">
    <div class="max-w-md mx-auto px-6 w-full">
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="/">
                <img src="/images/logo-blanc.png" alt="Link-Card" class="h-12 mx-auto" onerror="this.style.display='none'">
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-md p-8">
            {{-- Icône NFC --}}
            <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.858 15.355-5.858 21.213 0"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-center mb-2" style="color: #2C2A27;">Activer ma carte</h1>
            <p class="text-center text-sm mb-6" style="color: #4B5563;">
                Carte <span class="font-mono font-semibold" style="color: #42B574;">{{ $card->card_code }}</span>
            </p>

            @auth
                @php
                    $profiles = auth()->user()->profiles;
                @endphp

                @if($profiles->isEmpty())
                    <div class="text-center py-4">
                        <p class="text-sm mb-4" style="color: #4B5563;">
                            Vous n'avez pas encore de profil. Créez-en un d'abord.
                        </p>
                        <a href="{{ route('profile.create') }}" 
                           class="inline-block px-6 py-3 rounded-lg text-white font-medium"
                           style="background-color: #42B574;">
                            Créer mon profil
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('card.activate', $card->card_code) }}">
                        @csrf
                        
                        <label class="block text-sm font-medium mb-2" style="color: #2C2A27;">
                            Choisir le profil à lier
                        </label>

                        <div class="space-y-3 mb-6">
                            @foreach($profiles as $profile)
                                <label class="flex items-center p-3 rounded-xl border-2 cursor-pointer transition-all hover:border-[#42B574]"
                                       style="border-color: #E5E7EB;">
                                    <input type="radio" name="profile_id" value="{{ $profile->id }}" 
                                           class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="w-10 h-10 rounded-full flex-shrink-0 mr-3 overflow-hidden" 
                                         style="background-color: {{ $profile->primary_color ?? '#42B574' }};">
                                        @if($profile->photo_path)
                                            <img src="{{ Storage::url($profile->photo_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($profile->full_name ?? $profile->username, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate" style="color: #2C2A27;">
                                            {{ $profile->full_name ?? $profile->username }}
                                        </p>
                                        <p class="text-xs truncate" style="color: #9CA3AF;">
                                            {{ $profile->job_title ?? $profile->username }}
                                        </p>
                                    </div>
                                    <div class="w-5 h-5 rounded-full border-2 flex-shrink-0 flex items-center justify-center peer-checked:border-[#42B574] peer-checked:bg-[#42B574]"
                                         style="border-color: #D1D5DB;">
                                        <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('profile_id')
                            <p class="text-sm mb-4" style="color: #EF4444;">{{ $message }}</p>
                        @enderror

                        <button type="submit" 
                                class="w-full py-3 rounded-lg text-white font-medium transition-colors"
                                style="background-color: #42B574;"
                                onmouseover="this.style.backgroundColor='#3DA367'" 
                                onmouseout="this.style.backgroundColor='#42B574'">
                            Activer ma carte
                        </button>
                    </form>
                @endif
            @else
                <div class="text-center py-4">
                    <p class="text-sm mb-6" style="color: #4B5563;">
                        Connectez-vous ou créez un compte pour activer votre carte NFC.
                    </p>
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" 
                           class="block w-full py-3 rounded-lg text-white font-medium text-center"
                           style="background-color: #42B574;">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block w-full py-3 rounded-lg font-medium text-center border-2"
                           style="border-color: #D1D5DB; color: #2C2A27;">
                            Créer un compte
                        </a>
                    </div>
                </div>
            @endauth
        </div>

        <p class="text-center text-xs mt-6" style="color: #9CA3AF;">
            linkcard.ca
        </p>
    </div>
</body>
</html>
