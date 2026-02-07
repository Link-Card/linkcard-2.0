<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>Activer ma carte - Link-Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="font-family: 'Manrope', sans-serif; background-color: #F7F8F4;" class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-md p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
                    <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold" style="color: #2C2A27;">Activer ma carte</h1>
                <p class="mt-2 text-sm" style="color: #4B5563;">Code: <span class="font-mono font-semibold">{{ $card->card_code }}</span></p>
            </div>

            @auth
                @if($profiles->count() > 0)
                    <form method="POST" action="{{ route('card.activate', $card->card_code) }}">
                        @csrf
                        <label class="block text-sm font-medium mb-2" style="color: #2C2A27;">Lier à quel profil ?</label>
                        <select name="profile_id" class="w-full rounded-lg border px-4 py-3 text-sm mb-4" style="border-color: #D1D5DB; color: #2C2A27;">
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->full_name ?? $profile->username }}</option>
                            @endforeach
                        </select>

                        @error('profile_id')
                            <p class="text-sm mb-4" style="color: #EF4444;">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="w-full py-3 rounded-lg text-white font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
                            Activer la carte
                        </button>
                    </form>
                @else
                    <div class="text-center p-4 rounded-lg" style="background-color: #FEF3C7;">
                        <p class="text-sm" style="color: #92400E;">Vous devez d'abord créer un profil.</p>
                        <a href="{{ route('profile.create') }}" class="inline-block mt-3 px-4 py-2 rounded-lg text-white text-sm font-medium" style="background-color: #42B574;">
                            Créer un profil
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center">
                    <p class="text-sm mb-4" style="color: #4B5563;">Connectez-vous pour activer cette carte.</p>
                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="inline-block w-full py-3 rounded-lg text-white font-medium text-center transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
                        Se connecter
                    </a>
                    <p class="mt-3 text-sm" style="color: #9CA3AF;">
                        Pas de compte ? <a href="{{ route('register') }}" class="font-medium" style="color: #42B574;">S'inscrire</a>
                    </p>
                </div>
            @endauth
        </div>
        <div class="mt-6 text-center">
            <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-8 mx-auto opacity-40">
        </div>
    </div>
</body>
</html>
