@extends('emails.layout')

@section('content')
    <h1 class="email-title">Bienvenue sur Link-Card!</h1>
    <p class="email-subtitle">Vérifiez votre adresse email pour commencer.</p>

    <p class="email-text">
        Bonjour {{ $user->name }},
    </p>

    <p class="email-text">
        Merci de vous être inscrit sur Link-Card! Pour compléter votre inscription,
        cliquez sur le bouton ci-dessous:
    </p>

    <div style="text-align: center;">
        <a href="{{ $verificationUrl }}" class="email-btn">Vérifier mon email</a>
    </div>

    <p class="email-text" style="font-size: 12px; color: #9CA3AF;">
        Ce lien expirera dans 60 minutes.
    </p>

    <hr class="divider">

    <p class="email-text">
        Si vous n'avez pas créé de compte sur Link-Card, vous pouvez ignorer cet email.
    </p>

    <p style="font-size: 12px; color: #9CA3AF; word-break: break-all; margin-top: 16px;">
        Si le bouton ne fonctionne pas, copiez ce lien: {{ $verificationUrl }}
    </p>
@endsection
