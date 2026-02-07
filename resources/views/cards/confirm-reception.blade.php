{{--
    TODO MULTI-PROFILS:
    - Quand le système multi-profils sera implanté, ajouter ici un sélecteur
      de profil si le user a plusieurs profils (au lieu de confirmer direct)
    - Tester: commande carte sur profil A, mais user a aussi profil B
    - Tester: changement de profil lié après confirmation
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title>Confirmer ma carte — Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #F7F8F4;">
    <div class="max-w-md mx-auto px-6 w-full">

        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="/">
                <img src="/images/logo-noir.png" alt="Link-Card" class="h-10 mx-auto" onerror="this.style.display='none'">
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-md p-8">

            {{-- NFC icon --}}
            <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-center mb-2" style="color: #2C2A27;">
                Votre carte est arrivée!
            </h1>
            <p class="text-center text-sm mb-6" style="color: #4B5563;">
                Confirmez la réception pour activer votre carte NFC.
            </p>

            {{-- Card info --}}
            <div class="rounded-xl p-4 mb-6" style="background-color: #F3F4F6;">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium uppercase tracking-wider" style="color: #9CA3AF;">Code carte</span>
                    <span class="font-mono text-sm font-semibold" style="color: #42B574;">{{ $card->card_code }}</span>
                </div>

                @if($card->profile)
                    <div style="border-top: 1px solid #E5E7EB; padding-top: 12px;">
                        <span class="text-xs font-medium uppercase tracking-wider" style="color: #9CA3AF;">Profil lié</span>
                        <div class="flex items-center mt-2">
                            <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden"
                                 style="background-color: {{ $card->profile->primary_color ?? '#42B574' }};">
                                @if($card->profile->photo_path)
                                    <img src="{{ Storage::url($card->profile->photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($card->profile->full_name ?? $card->profile->username, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium" style="color: #2C2A27;">
                                    {{ $card->profile->full_name ?? $card->profile->username }}
                                </p>
                                @if($card->profile->job_title)
                                    <p class="text-xs" style="color: #9CA3AF;">{{ $card->profile->job_title }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @auth
                @if(auth()->id() === $card->user_id)
                    {{-- Owner logged in → confirm button --}}
                    <form method="POST" action="{{ route('card.confirm', $card->card_code) }}" onsubmit="this.querySelector('button').disabled=true; this.querySelector('.btn-text').style.display='none'; this.querySelector('.btn-loading').style.display='flex';">
                        @csrf
                        <button type="submit"
                                class="w-full py-3 rounded-lg text-white font-medium transition-colors disabled:opacity-60"
                                style="background-color: #42B574;"
                                onmouseover="this.style.backgroundColor='#3DA367'"
                                onmouseout="this.style.backgroundColor='#42B574'">
                            <span class="btn-text">Confirmer la réception</span>
                            <span class="btn-loading items-center justify-center" style="display: none;">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Activation en cours...
                            </span>
                        </button>
                    </form>
                    <p class="text-center text-xs mt-3" style="color: #9CA3AF;">
                        Votre carte sera activée et prête à l'emploi.
                    </p>
                @else
                    {{-- Logged in but wrong user --}}
                    <div class="text-center py-4">
                        <p class="text-sm mb-4" style="color: #4B5563;">
                            Cette carte appartient à un autre compte. Connectez-vous avec le bon compte pour la confirmer.
                        </p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-block px-6 py-3 rounded-lg font-medium text-center border-2"
                                    style="border-color: #D1D5DB; color: #2C2A27;">
                                Changer de compte
                            </button>
                        </form>
                    </div>
                @endif
            @else
                {{-- Not logged in --}}
                <div class="space-y-3">
                    <a href="{{ route('login') }}"
                       class="block w-full py-3 rounded-lg text-white font-medium text-center"
                       style="background-color: #42B574;">
                        Se connecter pour confirmer
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full py-3 rounded-lg font-medium text-center border-2"
                       style="border-color: #D1D5DB; color: #2C2A27;">
                        Créer un compte
                    </a>
                </div>
            @endauth
        </div>

        <p class="text-center text-xs mt-6" style="color: #9CA3AF;">
            linkcard.ca
        </p>
    </div>
</body>
</html>
