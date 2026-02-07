@extends('emails.layout')

@section('content')
    <h1 class="email-title">Commande confirmée!</h1>
    <p class="email-subtitle">Merci pour votre achat, {{ $order->user->name }}.</p>

    <p class="email-text">
        Nous avons bien reçu votre commande de carte(s) NFC Link-Card. 
        Votre paiement a été traité avec succès.
    </p>

    {{-- Résumé commande --}}
    <div class="info-box">
        <p class="info-label">Commande</p>
        <p class="info-value">{{ $order->order_number }}</p>

        <p class="info-label">Quantité</p>
        <p class="info-value">{{ $order->quantity }} carte(s) NFC</p>

        <p class="info-label">Design</p>
        <p class="info-value">{{ $order->design_type === 'custom' ? 'Personnalisé (avec logo)' : 'Standard Link-Card' }}</p>

        <p class="info-label">Total</p>
        <p class="info-value" style="font-size: 18px; color: #42B574;">{{ $order->amount_dollars }}$ CAD</p>
    </div>

    {{-- Adresse livraison --}}
    @if($order->shipping_address)
        <div class="info-box-blue">
            <p class="info-label">Livraison à</p>
            <p class="info-value">
                {{ $order->shipping_address['name'] }}<br>
                {{ $order->shipping_address['street'] }}<br>
                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['province'] }} {{ $order->shipping_address['postal_code'] }}
            </p>
        </div>
    @endif

    <hr class="divider">

    <p class="email-text">
        <strong>Prochaine étape:</strong> Nous allons préparer et programmer votre carte NFC. 
        Vous recevrez un email dès qu'elle sera en route.
    </p>

    <div style="text-align: center;">
        <a href="{{ url('/dashboard/cards') }}" class="email-btn">Voir mes cartes</a>
    </div>
@endsection
