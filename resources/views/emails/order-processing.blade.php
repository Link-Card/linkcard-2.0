@extends('emails.layout')

@section('content')
    <h1 class="email-title">Votre carte est en préparation</h1>
    <p class="email-subtitle">Commande {{ $order->order_number }}</p>

    <p class="email-text">
        Bonjour {{ $order->user->name }},
    </p>

    <p class="email-text">
        Bonne nouvelle! Nous avons commencé la préparation de votre commande. 
        Votre carte NFC est en cours de programmation avec votre profil Link-Card.
    </p>

    <div class="info-box">
        <p class="info-label">Statut</p>
        <p class="info-value"><span class="badge badge-blue">En traitement</span></p>

        <p class="info-label">Quantité</p>
        <p class="info-value">{{ $order->quantity }} carte(s) NFC</p>

        @if($order->items)
            <p class="info-label">Profil(s) lié(s)</p>
            @foreach($order->items as $item)
                <p class="info-value" style="margin-bottom: 4px;">
                    {{ $item['profile_name'] ?? 'Profil' }}
                    @if(($item['is_replacement'] ?? false))
                        <span class="badge badge-orange">Remplacement</span>
                    @endif
                </p>
            @endforeach
        @endif
    </div>

    <hr class="divider">

    <p class="email-text">
        Vous recevrez un autre email avec un numéro de suivi dès que votre carte sera expédiée. 
        Le délai habituel est de 2-5 jours ouvrables.
    </p>

    <div style="text-align: center;">
        <a href="{{ url('/dashboard/cards') }}" class="email-btn">Suivre ma commande</a>
    </div>
@endsection
