@extends('layouts.public')

@section('title', 'Forfaits — LinkCard')
@section('meta_description', 'Choisissez le forfait LinkCard qui vous convient. Bundles de lancement avec carte NFC incluse, ou forfaits mensuels Gratuit, Pro et Premium.')

@section('styles')
<style>
    .plan-card { background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 24px; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .plan-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.1); transform: translateY(-4px); }
    .plan-popular { border-color: #42B574; box-shadow: 0 4px 20px rgba(66,181,116,0.15); }
    .plan-popular::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #42B574, #3DA367); }
    .toggle-container { background: #F3F4F6; border-radius: 9999px; padding: 4px; display: inline-flex; }
    .toggle-btn { padding: 8px 20px; border-radius: 9999px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; background: transparent; color: #4B5563; }
    .toggle-btn.active { background: #42B574; color: #FFFFFF; }
    .btn-plan { display: block; width: 100%; text-align: center; padding: 12px 16px; border-radius: 10px; font-size: 14px; font-weight: 500; transition: all 0.2s; text-decoration: none; cursor: pointer; }
    .btn-plan-outline { background: transparent; border: 1px solid #E5E7EB; color: #2C2A27; }
    .btn-plan-outline:hover { border-color: #42B574; color: #42B574; }
    .btn-plan-green { background: #42B574; border: 1px solid #42B574; color: #FFFFFF; }
    .btn-plan-green:hover { background: #3DA367; }
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

{{-- ============================================ --}}
{{-- BUNDLES DE LANCEMENT (EN PREMIER) --}}
{{-- ============================================ --}}
<section class="py-12 sm:py-20" style="background-color: #FFFFFF;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-6 fade-up">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold" style="background: linear-gradient(135deg, #42B574, #3DA367); color: white;">🚀 Offre de lancement — Places limitées</span>
        </div>
        <div class="text-center mb-12 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Bundles de lancement</h2>
            <p class="mt-4 text-lg" style="color: #4B5563;">Carte NFC + abonnement Premium + 2e profil offert. Tout est inclus.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Découverte --}}
            <div class="plan-card fade-up">
                <h3 class="text-lg font-bold" style="color: #2C2A27;">Découverte</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">L'essentiel pour démarrer</p>
                <div class="mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold" style="color: #2C2A27;">59,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">74$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 19%</span>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        1 carte NFC
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        3 mois Premium
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #42B574; font-weight: 500;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5M2.25 12h19.5"/></svg>
                        🎁 2e profil offert
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Choisir</a>
            </div>

            {{-- Pro --}}
            <div class="plan-card plan-popular fade-up" style="transition-delay: 0.1s;">
                <div style="position: absolute; top: 16px; right: 16px; background-color: #F0F9F4; color: #42B574; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Populaire ⭐</div>
                <h3 class="text-lg font-bold" style="color: #2C2A27;">Pro</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">Le plus populaire</p>
                <div class="mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold" style="color: #2C2A27;">99,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">128$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 22%</span>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        1 carte NFC
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        1 profil supplémentaire
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        6 mois Premium
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #42B574; font-weight: 500;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5M2.25 12h19.5"/></svg>
                        🎁 2e profil offert
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-green">Choisir</a>
            </div>

            {{-- Duo --}}
            <div class="plan-card fade-up" style="transition-delay: 0.2s;">
                <div style="position: absolute; top: 16px; right: 16px; background-color: #FEF3C7; color: #92400E; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Meilleur deal</div>
                <h3 class="text-lg font-bold" style="color: #2C2A27;">Duo</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">Pour tout avoir</p>
                <div class="mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold" style="color: #2C2A27;">149,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">208$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 28%</span>
                </div>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        2 cartes NFC
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        2 profils
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #4B5563;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        6 mois Premium
                    </li>
                    <li class="flex items-center gap-2 text-sm" style="color: #42B574; font-weight: 500;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5M2.25 12h19.5"/></svg>
                        🎁 2e profil offert
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Choisir</a>
            </div>
        </div>
        <div class="text-center mt-8 fade-up">
            <p class="text-sm" style="color: #9CA3AF;">Après la période incluse : Premium continue à 8$/mois, annulable en tout temps.</p>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- FORFAITS STANDARDS (EN DEUXIÈME) --}}
{{-- ============================================ --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Forfaits standards</h2>
            <p class="mt-4 text-lg" style="color: #4B5563;">Sans engagement. Changez ou annulez en tout temps.</p>
            {{-- Toggle --}}
            <div class="mt-8">
                <div class="toggle-container" id="billingToggle">
                    <button class="toggle-btn active" onclick="setBilling('monthly')" id="btn-monthly">Mensuel</button>
                    <button class="toggle-btn" onclick="setBilling('yearly')" id="btn-yearly">
                        Annuel <span style="color: #42B574; font-size: 12px; font-weight: 600;">-17%</span>
                    </button>
                </div>
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
                <div class="space-y-3 mb-6">
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
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Créer mon profil</a>
            </div>

            {{-- PRO --}}
            <div class="plan-card fade-up" style="transition-delay: 0.1s;">
                <h3 class="text-xl font-bold" style="color: #2C2A27;">Pro</h3>
                <div class="mb-6 mt-4">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-pro">5$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-pro">/mois</span>
                </div>
                <div class="space-y-3 mb-6">
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
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Commencer</a>
            </div>

            {{-- PREMIUM --}}
            <div class="plan-card plan-popular fade-up" style="transition-delay: 0.2s;">
                <div style="position: absolute; top: 16px; right: 16px; background-color: #F0F9F4; color: #42B574; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Recommandé</div>
                <h3 class="text-xl font-bold" style="color: #2C2A27;">Premium</h3>
                <div class="mb-6 mt-4">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-premium">8$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-premium">/mois</span>
                </div>
                <div class="space-y-3 mb-6">
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
                <a href="{{ route('register') }}" class="btn-plan btn-plan-green">Commencer</a>
            </div>
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
