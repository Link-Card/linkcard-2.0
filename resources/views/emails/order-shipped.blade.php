@extends('emails.layout')

@section('content')
    <h1 class="email-title">Votre carte est en route! 🎉</h1>
    <p class="email-subtitle">Commande {{ $order->order_number }}</p>

    <p class="email-text">
        Bonjour {{ $order->user->name }},
    </p>

    <p class="email-text">
        Votre carte NFC Link-Card a été expédiée et est en chemin vers vous!
    </p>

    {{-- Tracking --}}
    @if($order->tracking_number)
        <div class="info-box" style="text-align: center;">
            <p class="info-label">Numéro de suivi</p>
            <p class="info-value" style="font-size: 18px; font-family: monospace; letter-spacing: 1px;">
                {{ $order->tracking_number }}
            </p>
            <a href="https://www.canadapost-postescanada.ca/track-reperage/fr#/search?searchFor={{ $order->tracking_number }}" 
               class="email-btn-secondary" style="margin-top: 8px;">
                Suivre mon colis
            </a>
        </div>
    @endif

    {{-- Livraison --}}
    @if($order->shipping_address)
        <div class="info-box-blue">
            <p class="info-label">Livré à</p>
            <p class="info-value">
                {{ $order->shipping_address['name'] }}<br>
                {{ $order->shipping_address['street'] }}<br>
                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['province'] }} {{ $order->shipping_address['postal_code'] }}
            </p>
        </div>
    @endif

    <hr class="divider">

    <h2 style="font-size: 16px; font-weight: 600; color: #2C2A27; margin: 0 0 12px 0;">
        Quand vous recevrez votre carte
    </h2>

    <p class="email-text" style="margin-bottom: 8px;">
        <strong style="color: #2C2A27;">1.</strong> Scannez la carte avec votre téléphone (NFC)
    </p>
    <p class="email-text" style="margin-bottom: 8px;">
        <strong style="color: #2C2A27;">2.</strong> Suivez le lien pour activer votre carte
    </p>
    <p class="email-text" style="margin-bottom: 8px;">
        <strong style="color: #2C2A27;">3.</strong> Choisissez le profil à lier
    </p>
    <p class="email-text">
        <strong style="color: #2C2A27;">4.</strong> C'est prêt! Chaque scan redirigera vers votre profil
    </p>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/dashboard/cards') }}" class="email-btn">Mes cartes</a>
    </div>
@endsection
