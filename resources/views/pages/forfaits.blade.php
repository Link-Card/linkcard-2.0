@extends('layouts.public')

@section('title', 'Forfaits — LinkCard')
@section('meta_description', 'Choisissez le forfait LinkCard qui vous convient. Gratuit, Pro ou Premium. Carte NFC, profil digital, connexions et statistiques.')

@section('styles')
<style>
    .plan-card { background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 24px; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .plan-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.1); transform: translateY(-4px); }
    .plan-popular { border-color: #42B574; box-shadow: 0 4px 20px rgba(66,181,116,0.15); }
    .plan-popular::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #42B574, #3DA367); }
    .toggle-container { background: #F3F4F6; border-radius: 9999px; padding: 4px; display: inline-flex; }
    .toggle-btn { padding: 8px 20px; border-radius: 9999px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; background: transparent; color: #4B5563; }
    .toggle-btn.active { background: #42B574; color: #FFFFFF; }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-12 sm:pb-16" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center fade-up">
        <h1 class="text-4xl sm:text-5xl font-bold" style="color: #2C2A27;">Un forfait pour chaque <span style="color: #42B574;">besoin</span></h1>
        <p class="mt-4 text-lg" style="color: #4B5563;">Commencez gratuitement, évoluez quand vous êtes prêt.</p>
    </div>
</section>

{{-- TOGGLE + PLANS --}}
<section class="py-12 sm:py-20" style="background-color: #FFFFFF;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        {{-- Toggle --}}
        <div class="text-center mb-12 fade-up">
            <div class="toggle-container" id="billingToggle">
                <button class="toggle-btn active" onclick="setBilling('monthly')" id="btn-monthly">Mensuel</button>
                <button class="toggle-btn" onclick="setBilling('yearly')" id="btn-yearly">
                    Annuel <span style="color: #42B574; font-size: 12px; font-weight: 600;">-17%</span>
                </button>
            </div>
        </div>

        {{-- Plans: Gratuit → Pro → Premium --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- GRATUIT --}}
            <div class="plan-card fade-up">
                <h3 class="text-xl font-bold" style="color: #2C2A27;">Gratuit</h3>
                <div class="mb-6 mt-4">
                    <span class="text-4xl font-bold" style="color: #2C2A27;">0$</span>
                    <span class="text-sm" style="color: #9CA3AF;">/mois</span>
                </div>
                <a href="{{ route('register') }}" class="btn btn-secondary w-full mb-6" style="border-radius: 10px;">Créer mon profil</a>
                <div class="space-y-3">
                    @php
                    $freeFeatures = ['1 profil', 'Code 8 caractères aléatoire', '3 liens sociaux', '2 images (sans liens)', '1 section texte'];
                    @endphp
                    @foreach($freeFeatures as $f)
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PRO --}}
            <div class="plan-card fade-up" style="transition-delay: 0.1s;">
                <h3 class="text-xl font-bold" style="color: #2C2A27;">Pro</h3>
                <div class="mb-6 mt-4">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-pro">5$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-pro">/mois</span>
                </div>
                <a href="{{ route('register') }}" class="btn btn-secondary w-full mb-6" style="border-radius: 10px;">Commencer</a>
                <div class="space-y-3">
                    @php
                    $proFeatures = ['1 profil (+5$/mois par extra)', 'Username personnalisé', '5 liens sociaux', '5 images avec liens', '2 sections texte', 'QR Code popup'];
                    @endphp
                    @foreach($proFeatures as $f)
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PREMIUM --}}
            <div class="plan-card plan-popular fade-up" style="transition-delay: 0.2s;">
                <div style="position: absolute; top: 16px; right: 16px; background-color: #F0F9F4; color: #42B574; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Recommandé</div>
                <h3 class="text-xl font-bold" style="color: #2C2A27;">Premium</h3>
                <div class="mb-6 mt-4">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-premium">8$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-premium">/mois</span>
                </div>
                <a href="{{ route('register') }}" class="btn btn-primary w-full mb-6" style="border-radius: 10px;">Commencer</a>
                <div class="space-y-3">
                    @php
                    $premiumFeatures = ['1 profil (+8$/mois par extra)', 'Username personnalisé obligatoire', '10 liens sociaux', '10 images avec liens', '5 sections texte', 'QR Code popup'];
                    @endphp
                    @foreach($premiumFeatures as $f)
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BUNDLES --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-6 fade-up">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold" style="background: linear-gradient(135deg, #42B574, #3DA367); color: white;">🚀 Offre de lancement — Places limitées</span>
        </div>
        <div class="text-center mb-12 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Bundles de lancement</h2>
            <p class="mt-4 text-lg" style="color: #4B5563;">Carte NFC + abonnement Premium. Tout est inclus.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $bundles = [
                ['name' => 'Découverte', 'desc' => 'L\'essentiel', 'items' => ['1 carte NFC', '3 mois Premium'], 'price' => '59,99$', 'old' => '74$', 'save' => '19%', 'badge' => null, 'btn' => 'btn-secondary'],
                ['name' => 'Pro', 'desc' => 'Le plus populaire', 'items' => ['1 carte NFC', '1 profil supplémentaire', '6 mois Premium'], 'price' => '99,99$', 'old' => '128$', 'save' => '22%', 'badge' => 'Populaire ⭐', 'btn' => 'btn-primary'],
                ['name' => 'Duo', 'desc' => 'Pour tout avoir', 'items' => ['2 cartes NFC', '2 profils', '6 mois Premium'], 'price' => '149,99$', 'old' => '208$', 'save' => '28%', 'badge' => 'Meilleur deal', 'btn' => 'btn-secondary'],
            ];
            @endphp
            @foreach($bundles as $bundle)
            <div class="fade-up {{ $bundle['badge'] === 'Populaire ⭐' ? 'plan-popular' : '' }}" style="background: #FFFFFF; border: 1px solid {{ $bundle['badge'] === 'Populaire ⭐' ? '#42B574' : '#E5E7EB' }}; border-radius: 16px; padding: 28px 24px; position: relative; overflow: hidden; transition-delay: {{ $loop->index * 0.1 }}s;">
                @if($bundle['badge'] === 'Populaire ⭐')
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #42B574, #3DA367);"></div>
                @endif
                @if($bundle['badge'])
                <div style="position: absolute; top: 16px; right: 16px; background-color: {{ $bundle['badge'] === 'Populaire ⭐' ? '#F0F9F4' : '#FEF3C7' }}; color: {{ $bundle['badge'] === 'Populaire ⭐' ? '#42B574' : '#92400E' }}; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">{{ $bundle['badge'] }}</div>
                @endif
                <h3 class="text-lg font-bold" style="color: #2C2A27;">{{ $bundle['name'] }}</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">{{ $bundle['desc'] }}</p>
                <div class="mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold" style="color: #2C2A27;">{{ $bundle['price'] }}</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">{{ $bundle['old'] }}</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez {{ $bundle['save'] }}</span>
                </div>
                <ul class="space-y-3 mb-6">
                    @foreach($bundle['items'] as $item)
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="{{ $bundle['btn'] }} w-full" style="border-radius: 10px;">Choisir</a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8 fade-up">
            <p class="text-sm" style="color: #9CA3AF;">Après la période incluse : Premium continue à 8$/mois, annulable en tout temps.</p>
        </div>
    </div>
</section>

{{-- 2e PROFIL OFFERT --}}
<section class="py-10" style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="fade-up" style="background: linear-gradient(135deg, #F0F9F4 0%, #EFF6FF 100%); border-radius: 16px; padding: 24px 28px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center; text-align: center;">
            <span class="text-2xl">🎁</span>
            <p class="text-sm sm:text-base font-medium" style="color: #2C2A27;"><strong>Offre de lancement :</strong> 2e profil offert pour les 250 premiers inscrits</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">En profiter</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
function setBilling(type) {
    const monthly = type === 'monthly';
    document.getElementById('btn-monthly').classList.toggle('active', monthly);
    document.getElementById('btn-yearly').classList.toggle('active', !monthly);
    document.getElementById('price-premium').textContent = monthly ? '8$' : '80$';
    document.getElementById('period-premium').textContent = monthly ? '/mois' : '/an';
    document.getElementById('price-pro').textContent = monthly ? '5$' : '50$';
    document.getElementById('period-pro').textContent = monthly ? '/mois' : '/an';
}
</script>
@endsection
