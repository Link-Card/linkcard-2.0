@extends('emails.layout')

@section('content')
    <h1 class="email-title">Bienvenue sur Link-Card!</h1>
    <p class="email-subtitle">Bonjour {{ $user->name }}, votre compte est prêt.</p>

    <p class="email-text">
        Vous venez de rejoindre Link-Card, la plateforme qui transforme chaque rencontre en connexion durable.
        Voici comment démarrer en 3 étapes simples:
    </p>

    {{-- Étapes --}}
    <div class="info-box">
        <div style="margin-bottom: 16px;">
            <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background-color: #42B574; color: white; text-align: center; line-height: 28px; font-size: 14px; font-weight: 600; margin-right: 12px;">1</span>
            <strong style="color: #2C2A27;">Créez votre profil</strong>
            <p class="email-text" style="margin: 4px 0 0 40px;">Ajoutez vos infos, vos réseaux sociaux et votre photo.</p>
        </div>

        <div style="margin-bottom: 16px;">
            <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background-color: #42B574; color: white; text-align: center; line-height: 28px; font-size: 14px; font-weight: 600; margin-right: 12px;">2</span>
            <strong style="color: #2C2A27;">Partagez votre lien</strong>
            <p class="email-text" style="margin: 4px 0 0 40px;">Envoyez votre URL unique ou votre QR code à vos contacts.</p>
        </div>

        <div>
            <span style="display: inline-block; width: 28px; height: 28px; border-radius: 50%; background-color: #42B574; color: white; text-align: center; line-height: 28px; font-size: 14px; font-weight: 600; margin-right: 12px;">3</span>
            <strong style="color: #2C2A27;">Commandez votre carte NFC</strong>
            <p class="email-text" style="margin: 4px 0 0 40px;">Partagez votre profil d'un simple tap avec votre carte physique.</p>
        </div>
    </div>

    <div style="text-align: center;">
        <a href="{{ url('/dashboard') }}" class="email-btn">Créer mon profil</a>
    </div>

    <hr class="divider">

    <p class="email-text" style="font-size: 13px; color: #9CA3AF;">
        Besoin d'aide? Répondez directement à cet email, on est là pour vous.
    </p>
@endsection
