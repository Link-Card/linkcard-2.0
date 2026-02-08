@extends('emails.layout')

@section('content')
    <h1 class="email-title">Connexion acceptée! 🎉</h1>
    <p class="email-subtitle">{{ $accepter->name }} a accepté votre demande de connexion.</p>

    @if($accepterProfile)
        <div class="info-box">
            <p class="info-value" style="font-size: 16px; margin-bottom: 4px;">{{ $accepter->name }}</p>
            @if($accepterProfile->job_title)
                <p class="email-text" style="margin: 0;">{{ $accepterProfile->job_title }}{{ $accepterProfile->company ? ' @ '.$accepterProfile->company : '' }}</p>
            @endif
        </div>
    @endif

    <p class="email-text">
        Vous êtes maintenant connectés sur Link-Card.
        Retrouvez {{ $accepter->name }} dans vos contacts.
    </p>

    <div style="text-align: center; margin: 24px 0;">
        <a href="{{ url('/dashboard/connections') }}" class="email-btn">
            Voir mes contacts
        </a>
    </div>

    <hr class="divider">

    <p class="email-text" style="font-size: 12px; color: #9CA3AF;">
        Vous pouvez gérer vos notifications dans vos <a href="{{ url('/dashboard/preferences') }}" style="color: #42B574;">préférences</a>.
    </p>
@endsection
