@extends('emails.layout')

@section('content')
    <h1 class="email-title">🔔 Nouvelle commande!</h1>
    <p class="email-subtitle">Une commande vient d'être passée sur Link-Card.</p>

    {{-- Résumé commande --}}
    <div class="info-box">
        <p class="info-label">Commande</p>
        <p class="info-value">{{ $order->order_number }}</p>

        <p class="info-label">Client</p>
        <p class="info-value">{{ $order->user->name }} ({{ $order->user->email }})</p>

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

    {{-- Cartes à programmer --}}
    @if($order->items)
        <div class="info-box">
            <p class="info-label">Cartes à programmer</p>
            @foreach($order->items as $item)
                <p class="info-value">{{ $item['profile_name'] ?? 'Profil' }} — {{ $item['quantity'] ?? 1 }} carte(s)</p>
                @foreach(($item['card_codes'] ?? (isset($item['card_code']) ? [$item['card_code']] : [])) as $code)
                    <p class="info-value" style="font-family: 'Courier New', monospace; margin-left: 15px;">
                        → {{ $code }}
                    </p>
                @endforeach
            @endforeach
        </div>
    @endif

    <hr class="divider">

    <div style="text-align: center;">
        <a href="{{ url('/admin') }}" class="email-btn">Gérer dans l'admin</a>
    </div>
@endsection
