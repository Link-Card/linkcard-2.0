@extends('emails.layout')

@section('content')
    <h1 class="email-title">Nouvelle demande de connexion</h1>
    <p class="email-subtitle">{{ $senderProfile->full_name ?? $sender->name }} souhaite se connecter avec vous.</p>

    @if($senderProfile)
        <div class="info-box">
            <p class="info-value" style="font-size: 16px; margin-bottom: 4px;">{{ $senderProfile->full_name ?? $sender->name }}</p>
            @if($senderProfile->job_title)
                <p class="email-text" style="margin: 0;">{{ $senderProfile->job_title }}{{ $senderProfile->company ? ' @ '.$senderProfile->company : '' }}</p>
            @endif
        </div>
    @endif

    <p class="email-text">
        Acceptez cette demande pour ajouter {{ $senderProfile->full_name ?? $sender->name }} à vos contacts Link-Card.
        Vous pourrez ainsi rester connectés facilement.
    </p>

    <div style="text-align: center; margin: 24px 0;">
        <a href="{{ url('/dashboard/connections') }}" class="email-btn">
            Voir la demande
        </a>
    </div>

    <hr class="divider">

    <p class="email-text" style="font-size: 12px; color: #9CA3AF;">
        Vous recevez cet email car quelqu'un a demandé à se connecter avec vous sur Link-Card. 
        Vous pouvez gérer vos notifications dans vos <a href="{{ url('/dashboard/preferences') }}" style="color: #42B574;">préférences</a>.
    </p>
@endsection
