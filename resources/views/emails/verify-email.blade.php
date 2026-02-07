@extends('emails.layout')

@section('content')
    <h1 class="email-title">Vérifiez votre email</h1>
    <p class="email-subtitle">Entrez ce code dans l'application pour confirmer votre adresse.</p>

    <p class="email-text">
        Bonjour {{ $user->name }},
    </p>

    <p class="email-text">
        Voici votre code de vérification:
    </p>

    {{-- Code box --}}
    <div style="text-align: center; margin: 24px 0;">
        <div style="display: inline-block; background-color: #F3F4F6; border: 2px solid #E5E7EB; border-radius: 12px; padding: 20px 40px;">
            <span style="font-family: 'Courier New', monospace; font-size: 36px; font-weight: 700; letter-spacing: 8px; color: #2C2A27;">{{ $verificationCode }}</span>
        </div>
    </div>

    <p class="email-text" style="font-size: 12px; color: #9CA3AF; text-align: center;">
        Ce code expire dans 30 minutes.
    </p>

    <hr class="divider">

    <p class="email-text" style="font-size: 12px; color: #9CA3AF;">
        Si vous n'avez pas créé de compte sur Link-Card, vous pouvez ignorer cet email.
    </p>
@endsection
