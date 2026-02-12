@extends('layouts.public')

@section('title', 'Forfaits — Link-Card')
@section('meta_description', 'Choisissez le forfait Link-Card qui vous convient. Bundles de lancement avec carte NFC incluse, ou forfaits mensuels Gratuit, Pro et Premium.')

@section('styles')
<style>
    /* Dashboard-matching card style */
    .plan-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 28px 24px;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .plan-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .plan-popular { border: 2px solid #42B574; }

    /* Toggle */
    .toggle-container { background: #F3F4F6; border-radius: 9999px; padding: 4px; display: inline-flex; }
    .toggle-btn { padding: 8px 20px; border-radius: 9999px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; background: transparent; color: #4B5563; }
    .toggle-btn.active { background: #42B574; color: #FFFFFF; }

    /* Buttons matching dashboard */
    .btn-plan {
        display: block;
        width: 100%;
        text-align: center;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
        cursor: pointer;
        margin-top: auto;
    }
    .btn-plan-outline {
        background: transparent;
        border: 1px solid #E5E7EB;
        color: #4B5563;
    }
    .btn-plan-outline:hover { border-color: #42B574; color: #42B574; }
    .btn-plan-green {
        background: #42B574;
        border: 1px solid #42B574;
        color: #FFFFFF;
    }
    .btn-plan-green:hover { background: #3DA367; }

    /* Feature list */
    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 6px 0;
    }
    .feature-item .check {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Badge */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-10 sm:pb-14" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center fade-up">
        <h1 class="text-4xl sm:text-5xl font-bold" style="color: #2C2A27;">Un forfait pour chaque <span style="color: #42B574;">besoin</span></h1>
        <p class="mt-4 text-lg" style="color: #4B5563;">Commencez gratuitement, évoluez quand vous êtes prêt.</p>
    </div>
</section>

{{-- ============================================ --}}
{{-- BUNDLES DE LANCEMENT (EN PREMIER) --}}
{{-- ============================================ --}}
<section class="py-10 sm:py-16" style="background-color: #FFFFFF;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-5 fade-up">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold" style="background: linear-gradient(135deg, #42B574, #3DA367); color: white;">🚀 Offre de lancement — Places limitées</span>
        </div>
        <div class="text-center mb-10 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Bundles de lancement</h2>
            <p class="mt-3 text-base" style="color: #4B5563;">Carte NFC + abonnement + profil bonus. Tout est inclus.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- DÉCOUVERTE --}}
            <div class="plan-card fade-up">
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Découverte</h3>
                    <p class="text-sm mt-1" style="color: #9CA3AF;">L'essentiel pour démarrer</p>
                </div>
                <div class="mt-4 mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold" style="color: #2C2A27;">59,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">75$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 20%</span>
                </div>
                <div class="space-y-1 mb-6">
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">1 carte NFC</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">3 mois Pro inclus</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span class="text-sm font-medium" style="color: #42B574;">🎁 +1 profil offert (total : 2)</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Choisir</a>
            </div>

            {{-- DUO (POPULAIRE) --}}
            <div class="plan-card plan-popular fade-up" style="transition-delay: 0.1s;">
                <div style="position: absolute; top: 14px; right: 14px;">
                    <span class="badge" style="background-color: #F0F9F4; color: #42B574;">Populaire ⭐</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Duo</h3>
                    <p class="text-sm mt-1" style="color: #9CA3AF;">2 cartes, 2 profils</p>
                </div>
                <div class="mt-4 mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold" style="color: #2C2A27;">99,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">130$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 23%</span>
                </div>
                <div class="space-y-1 mb-6">
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">2 cartes NFC</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">6 mois Pro inclus</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span class="text-sm font-medium" style="color: #42B574;">🎁 +1 profil offert (total : 2)</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-green">Choisir</a>
            </div>

            {{-- TRIO (MEILLEUR DEAL) --}}
            <div class="plan-card fade-up" style="transition-delay: 0.2s;">
                <div style="position: absolute; top: 14px; right: 14px;">
                    <span class="badge" style="background-color: #FEF3C7; color: #92400E;">Meilleur deal</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Trio</h3>
                    <p class="text-sm mt-1" style="color: #9CA3AF;">3 cartes, 3 profils</p>
                </div>
                <div class="mt-4 mb-5">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold" style="color: #2C2A27;">149,99$</span>
                        <span class="text-sm line-through" style="color: #9CA3AF;">210$</span>
                    </div>
                    <span class="text-xs font-medium" style="color: #42B574;">Économisez 29%</span>
                </div>
                <div class="space-y-1 mb-6">
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">3 cartes NFC</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">2 profils inclus</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">6 mois Premium inclus</span>
                    </div>
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span class="text-sm font-medium" style="color: #42B574;">🎁 +1 profil offert (total : 3)</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Choisir</a>
            </div>
        </div>

        <div class="text-center mt-6 fade-up">
            <p class="text-sm" style="color: #9CA3AF;">Après la période incluse : l'abonnement continue au tarif standard, annulable en tout temps.</p>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- FORFAITS STANDARDS (EN DEUXIÈME) --}}
{{-- ============================================ --}}
<section class="py-14 sm:py-20" style="background-color: #F7F8F4;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Forfaits standards</h2>
            <p class="mt-3 text-base" style="color: #4B5563;">Sans engagement. Changez ou annulez en tout temps.</p>
            <div class="mt-6">
                <div class="toggle-container">
                    <button class="toggle-btn active" onclick="setBilling('monthly')" id="btn-monthly">Mensuel</button>
                    <button class="toggle-btn" onclick="setBilling('yearly')" id="btn-yearly">
                        Annuel <span style="color: #42B574; font-size: 12px; font-weight: 600;">-17%</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- GRATUIT --}}
            <div class="plan-card fade-up">
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Gratuit</h3>
                </div>
                <div class="mt-4 mb-5">
                    <span class="text-4xl font-bold" style="color: #2C2A27;">0$</span>
                    <span class="text-sm" style="color: #9CA3AF;">/mois</span>
                </div>
                <div class="space-y-1 mb-6">
                    @foreach(['1 profil', 'Code 8 caractères aléatoire', '3 liens sociaux', '2 images (sans liens)', '1 section texte'] as $f)
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Créer mon profil</a>
            </div>

            {{-- PRO --}}
            <div class="plan-card fade-up" style="transition-delay: 0.1s;">
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Pro</h3>
                </div>
                <div class="mt-4 mb-5">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-pro">5$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-pro">/mois</span>
                </div>
                <div class="space-y-1 mb-6">
                    @foreach(['1 profil (+5$/mois par extra)', 'Username personnalisé', '5 liens sociaux', '5 images avec liens', '2 sections texte', 'QR Code popup'] as $f)
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('register') }}" class="btn-plan btn-plan-outline">Commencer</a>
            </div>

            {{-- PREMIUM --}}
            <div class="plan-card plan-popular fade-up" style="transition-delay: 0.2s;">
                <div style="position: absolute; top: 14px; right: 14px;">
                    <span class="badge" style="background-color: #F0F9F4; color: #42B574;">Recommandé</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold" style="color: #2C2A27;">Premium</h3>
                </div>
                <div class="mt-4 mb-5">
                    <span class="text-4xl font-bold" style="color: #2C2A27;" id="price-premium">8$</span>
                    <span class="text-sm" style="color: #9CA3AF;" id="period-premium">/mois</span>
                </div>
                <div class="space-y-1 mb-6">
                    @foreach(['1 profil (+8$/mois par extra)', 'Username personnalisé obligatoire', '10 liens sociaux', '10 images avec liens', '5 sections texte', 'QR Code popup'] as $f)
                    <div class="feature-item">
                        <svg class="check" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
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
