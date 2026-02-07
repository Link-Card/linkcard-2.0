@extends('emails.layout')

{{--
    TODO POST-LAUNCH:
    - Personnaliser cet email pour expliquer brièvement Link-Card aux nouveaux utilisateurs
    - Ajouter des points forts / fonctionnalités clés à découvrir
    - Ajouter un CTA vers des fonctionnalités premium
    - Solliciter les features qu'ils aimeraient utiliser (mini-sondage?)
    
    TODO MULTI-PROFILS:
    - Tester le flow complet quand un user a plusieurs profils sur son compte
    - S'assurer que la page confirm-reception gère bien le cas multi-profils
    - Tester le changement de profil lié depuis le dashboard cartes
--}}

@section('content')
    <h1 class="email-title">Carte activée avec succès!</h1>
    <p class="email-subtitle">Votre carte NFC est prête à l'emploi.</p>

    <p class="email-text">
        Bonjour {{ $card->user->name }},
    </p>

    <p class="email-text">
        Votre carte NFC Link-Card a été activée et liée à votre profil. 
        Chaque scan redirigera automatiquement vers votre profil public.
    </p>

    <div class="info-box" style="text-align: center;">
        <p class="info-label">Code carte</p>
        <p class="info-value" style="font-size: 20px; font-family: monospace; letter-spacing: 2px; color: #42B574;">
            {{ $card->card_code }}
        </p>

        @if($card->profile)
            <p class="info-label" style="margin-top: 12px;">Profil lié</p>
            <p class="info-value">{{ $card->profile->full_name ?? $card->profile->username }}</p>

            <p class="info-label">URL publique</p>
            <p class="info-value">
                <a href="{{ url('/' . $card->profile->username) }}" style="color: #42B574; text-decoration: none;">
                    linkcard.ca/{{ $card->profile->username }}
                </a>
            </p>
        @endif
    </div>

    <hr class="divider">

    <p class="email-text">
        <strong>Astuce:</strong> Vous pouvez changer le profil lié à votre carte à tout moment 
        depuis votre tableau de bord, sans avoir à reprogrammer la carte physique.
    </p>

    <div style="text-align: center;">
        <a href="{{ url('/dashboard/cards') }}" class="email-btn">Gérer mes cartes</a>
    </div>
@endsection
