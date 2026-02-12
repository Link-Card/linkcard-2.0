@extends('layouts.public')

@section('title', 'Carte NFC — Link-Card')
@section('meta_description', 'Découvrez la carte NFC Link-Card. Un geste suffit pour partager votre profil professionnel. Compatible tous smartphones, PVC premium, fabriquée au Québec.')

@section('styles')
<style>
    @keyframes floatCard { 0%, 100% { transform: translateY(0) rotate(-3deg); } 50% { transform: translateY(-12px) rotate(-3deg); } }
    .float-card { animation: floatCard 5s ease-in-out infinite; }
    @keyframes pulse-nfc { 0% { transform: scale(1); opacity: 0.6; } 100% { transform: scale(2.5); opacity: 0; } }
    .pulse-ring { position: absolute; width: 80px; height: 80px; border-radius: 50%; border: 2px solid rgba(66,181,116,0.3); animation: pulse-nfc 2.5s ease-out infinite; }
    .pulse-ring:nth-child(2) { animation-delay: 0.8s; }
    .pulse-ring:nth-child(3) { animation-delay: 1.6s; }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-16 sm:pb-24" style="background: linear-gradient(165deg, #2C2A27 0%, #1A1918 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -100px; right: -100px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(66,181,116,0.12) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -80px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(74,127,191,0.06) 0%, transparent 70%); pointer-events: none;"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 text-center lg:text-left fade-up">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-6" style="background: rgba(66,181,116,0.15); color: #42B574;">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0"/><circle cx="12" cy="18.75" r="0.75" fill="currentColor"/></svg>
                    Technologie NFC
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold leading-tight text-white">
                    La dernière carte de visite<br>que vous aurez à <span style="color: #42B574;">imprimer</span>.
                </h1>
                <p class="mt-6 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0" style="color: #9CA3AF;">
                    Une seule carte. Des centaines de connexions possibles. Votre contact, directement dans le téléphone de votre interlocuteur.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    <a href="{{ route('pages.forfaits') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                        Commander ma carte
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#comment-ca-marche" class="btn btn-secondary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px; border-color: rgba(255,255,255,0.2); color: #FFFFFF;">
                        Comment ça marche
                    </a>
                </div>
                <p class="mt-4 text-sm" style="color: #6B7280;">À partir de 37,49$ · Livraison 5-10 jours ouvrables</p>
            </div>
            <div class="flex-shrink-0 fade-up" style="transition-delay: 0.15s;">
                <div class="relative">
                    {{-- Pulse rings --}}
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                        <div class="pulse-ring"></div>
                    </div>
                    {{-- Card vertical --}}
                    <div class="float-card" style="width: 200px; height: 310px; background: linear-gradient(180deg, #FFFFFF 0%, #F9FAF7 100%); border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.25); display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #E5E7EB; position: relative; overflow: hidden; z-index: 5;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #42B574, #4A7FBF);"></div>
                        <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" style="width: 110px; height: auto; object-fit: contain;">
                        <div style="position: absolute; bottom: 16px; right: 16px;">
                            <svg width="20" height="20" fill="none" stroke="rgba(156,163,175,0.6)" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0"/><circle cx="12" cy="18.75" r="0.75" fill="rgba(156,163,175,0.6)"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- COMMENT ÇA MARCHE --}}
<section id="comment-ca-marche" class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Simple comme <span style="color: #42B574;">1, 2, 3</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12">
            @php
            $steps = [
                ['num' => '1', 'title' => 'Commandez en ligne', 'desc' => 'Choisissez votre design (standard ou personnalisé avec votre logo) et passez commande en quelques clics.'],
                ['num' => '2', 'title' => 'Recevez chez vous', 'desc' => 'Votre carte est programmée et expédiée en 5 à 10 jours ouvrables, directement à votre porte.'],
                ['num' => '3', 'title' => 'Connectez partout', 'desc' => 'Approchez votre carte d\'un téléphone. Votre profil s\'ouvre. Le contact est créé. C\'est tout.'],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="text-center fade-up" style="transition-delay: {{ ($loop->index) * 0.1 }}s;">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full mb-5" style="background-color: #F0F9F4; color: #42B574; font-size: 22px; font-weight: 700;">
                    {{ $step['num'] }}
                </div>
                <h3 class="text-lg font-bold mb-2" style="color: #2C2A27;">{{ $step['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CARACTÉRISTIQUES --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Conçue pour <span style="color: #42B574;">durer</span></h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $specs = [
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>', 'title' => 'Tous les smartphones', 'desc' => 'iPhone 7+ et la grande majorité des Android. Plus de 95% des téléphones en circulation.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>', 'title' => 'PVC premium', 'desc' => 'Résistante à l\'eau, aux égratignures et à l\'usure. Comme une carte bancaire, faite pour durer.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/>', 'title' => 'URL permanente', 'desc' => 'Changez de profil, de template ou d\'informations sans jamais changer votre carte physique.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>', 'title' => 'Design personnalisable', 'desc' => 'Ajoutez votre logo pour un design unique. Standard ou custom, c\'est votre choix.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>', 'title' => 'Fabriquée au Québec', 'desc' => 'Imprimée et programmée localement, en Mauricie. Achat local, qualité garantie.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>', 'title' => 'Aucune batterie', 'desc' => 'La carte fonctionne passivement — elle tire son énergie du téléphone qui la scanne. Aucune charge nécessaire.'],
            ];
            @endphp
            @foreach($specs as $spec)
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px 24px; transition: all 0.3s ease; transition-delay: {{ ($loop->index % 3) * 0.05 }}s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(66,181,116,0.12)'" onmouseout="this.style.boxShadow='none'">
                <div class="inline-flex items-center justify-center w-11 h-11 rounded-xl mb-4" style="background-color: #F0F9F4;">
                    <svg class="w-5 h-5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5">{!! $spec['icon'] !!}</svg>
                </div>
                <h3 class="text-base font-bold mb-2" style="color: #2C2A27;">{{ $spec['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">{{ $spec['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- COMPARAISON --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Carte papier vs <span style="color: #42B574;">Link-Card</span></h2>
        </div>
        <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; overflow: hidden;">
            <div class="grid grid-cols-3 text-center text-sm font-semibold" style="background-color: #F7F8F4; border-bottom: 1px solid #E5E7EB;">
                <div class="py-4 px-3"></div>
                <div class="py-4 px-3" style="color: #9CA3AF;">Papier</div>
                <div class="py-4 px-3" style="color: #42B574;">Link-Card</div>
            </div>
            @php
            $rows = [
                ['label' => 'Après un événement', 'paper' => 'Jetée ou perdue', 'link' => 'Toujours accessible'],
                ['label' => 'Mise à jour', 'paper' => 'Réimpression', 'link' => 'Temps réel'],
                ['label' => 'Suivi', 'paper' => 'Aucun', 'link' => 'Stats de scan'],
                ['label' => 'Environnement', 'paper' => 'Papier + encre', 'link' => 'Réutilisable'],
                ['label' => 'Coût', 'paper' => '500 = 80$+', 'link' => '1 carte = ∞'],
            ];
            @endphp
            @foreach($rows as $row)
            <div class="grid grid-cols-3 items-center text-sm" style="{{ !$loop->last ? 'border-bottom: 1px solid #F3F4F6;' : '' }}">
                <div class="py-3.5 px-4 font-medium text-xs sm:text-sm" style="color: #2C2A27;">{{ $row['label'] }}</div>
                <div class="py-3.5 px-3 text-center" style="color: #9CA3AF;">
                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="#EF4444" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span class="hidden sm:block text-xs mt-1">{{ $row['paper'] }}</span>
                </div>
                <div class="py-3.5 px-3 text-center" style="color: #2C2A27;">
                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span class="hidden sm:block text-xs mt-1">{{ $row['link'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PRIX --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <div class="fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold mb-12" style="color: #2C2A27;">Tarifs simples, <span style="color: #42B574;">sans surprise</span></h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-xl mx-auto">
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px 24px;">
                <p class="text-sm font-medium mb-1" style="color: #9CA3AF;">Gratuit & Pro</p>
                <p class="text-3xl font-bold" style="color: #2C2A27;">49,99$</p>
                <p class="text-xs mt-1" style="color: #9CA3AF;">par carte</p>
            </div>
            <div class="fade-up" style="background: #FFFFFF; border: 2px solid #42B574; border-radius: 16px; padding: 28px 24px; transition-delay: 0.1s;">
                <p class="text-sm font-medium mb-1" style="color: #42B574;">Premium</p>
                <p class="text-3xl font-bold" style="color: #2C2A27;">37,49$</p>
                <p class="text-xs mt-1" style="color: #42B574;">-25% sur chaque carte</p>
            </div>
        </div>
        <div class="mt-8 fade-up">
            <a href="{{ route('pages.forfaits') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                Commander ma carte
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="mt-3 text-sm" style="color: #9CA3AF;">Design personnalisé : même prix, ajoutez votre logo à la commande</p>
        </div>
    </div>
</section>

@endsection
