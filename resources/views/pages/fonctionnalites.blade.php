@extends('layouts.public')

@section('title', 'Fonctionnalités — LinkCard')
@section('meta_description', 'Découvrez toutes les fonctionnalités de LinkCard : profil digital, carte NFC, QR Code, connexions, statistiques et 13 templates professionnels.')

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-16 sm:pb-20" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <div class="fade-up">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-6" style="background-color: #F0F9F4; color: #42B574;">
                Tout ce dont vous avez besoin
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold leading-tight" style="color: #2C2A27;">
                La carte professionnelle<br>pensée pour <span style="color: #42B574;">aujourd'hui</span>
            </h1>
            <p class="mt-6 text-lg max-w-2xl mx-auto leading-relaxed" style="color: #4B5563;">
                LinkCard centralise vos coordonnées et vos liens professionnels dans un profil simple, accessible et modifiable à tout moment.
            </p>
        </div>
    </div>
</section>

{{-- PROFIL DIGITAL --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="fade-up">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #F0F9F4; color: #42B574;">
                    01 — Profil digital
                </div>
                <h2 class="text-3xl font-bold mb-6" style="color: #2C2A27;">Votre carte de visite digitale, prête en 2 minutes</h2>
                <p class="text-base leading-relaxed mb-6" style="color: #4B5563;">
                    Ajoutez votre photo, vos informations de contact, vos liens sociaux, vos textes et vos images. Choisissez parmi 13 templates professionnels et personnalisez les couleurs pour refléter votre identité.
                </p>
                <div class="space-y-3">
                    @php
                    $profilFeatures = [
                        'Photo de profil + bannière personnalisable',
                        'Jusqu\'à 10 liens sociaux (LinkedIn, Instagram, etc.)',
                        'Sections texte, images et boutons d\'action',
                        '13 templates au choix (gratuits + premium)',
                        'Personnalisation des couleurs (gradient 2 tons)',
                        'Drag & drop pour réorganiser vos sections',
                    ];
                    @endphp
                    @foreach($profilFeatures as $feature)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="fade-up" style="transition-delay: 0.1s;">
                <div style="background: linear-gradient(135deg, #F0F9F4, #EFF6FF); border-radius: 20px; padding: 40px; text-align: center;">
                    <div style="width: 220px; height: 400px; background: #1A1A1A; border-radius: 32px; padding: 10px; margin: 0 auto; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
                        <div style="width: 100%; height: 100%; border-radius: 22px; overflow: hidden; background: #FFFFFF;">
                            <div style="height: 140px; background: linear-gradient(135deg, #42B574, #3DA367); display: flex; flex-direction: column; align-items: center; justify-content: flex-end; padding-bottom: 12px;">
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: #FFFFFF; border: 3px solid #FFFFFF; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 5;">
                                    <svg class="w-6 h-6" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                                </div>
                                <span style="color: #FFFFFF; font-size: 12px; font-weight: 600; margin-top: 4px; z-index: 5;">Marie Tremblay</span>
                                <span style="color: rgba(255,255,255,0.8); font-size: 9px; z-index: 5;">Consultante Marketing</span>
                            </div>
                            <div style="padding: 16px 12px; display: flex; flex-direction: column; gap: 6px;">
                                <div style="height: 30px; border-radius: 6px; background: #42B574; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: 600;">Ajouter au contact</div>
                                <div style="height: 30px; border-radius: 6px; background: #F3F4F6; display: flex; align-items: center; padding: 0 10px; font-size: 10px; color: #2C2A27; gap: 6px;"><span style="color: #0A66C2; font-weight: bold;">in</span> LinkedIn</div>
                                <div style="height: 30px; border-radius: 6px; background: #F3F4F6; display: flex; align-items: center; padding: 0 10px; font-size: 10px; color: #2C2A27;">📸 Instagram</div>
                                <div style="height: 30px; border-radius: 6px; background: #F3F4F6; display: flex; align-items: center; padding: 0 10px; font-size: 10px; color: #2C2A27;">🌐 Portfolio</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARTE NFC --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1 fade-up">
                <div style="background: linear-gradient(135deg, #2C2A27, #1A1918); border-radius: 20px; padding: 40px; text-align: center;">
                    <div style="width: 260px; height: 164px; background: linear-gradient(135deg, #2C2A27 0%, #3a3835 100%); border-radius: 14px; margin: 0 auto; box-shadow: 0 15px 40px rgba(0,0,0,0.3); display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.08); position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: radial-gradient(circle at top right, rgba(66,181,116,0.2), transparent 70%);"></div>
                        <svg viewBox="0 0 40 40" fill="none" style="width: 44px; height: 44px;"><path d="M12 20c0-4.4 3.6-8 8-8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/><path d="M28 20c0 4.4-3.6 8-8 8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/><circle cx="16" cy="20" r="4" fill="#42B574" opacity="0.3"/><circle cx="24" cy="20" r="4" fill="#42B574" opacity="0.3"/></svg>
                        <div style="margin-top: 6px; font-size: 16px; font-weight: 700; letter-spacing: -0.02em;"><span style="color: #42B574;">LINK</span><span style="color: #FFFFFF;">CARD</span></div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 fade-up">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #F0F9F4; color: #42B574;">
                    02 — Carte NFC
                </div>
                <h2 class="text-3xl font-bold mb-6" style="color: #2C2A27;">Un geste suffit pour partager votre profil</h2>
                <p class="text-base leading-relaxed mb-6" style="color: #4B5563;">
                    Approchez votre carte du téléphone de votre interlocuteur. Votre profil s'ouvre instantanément — sans application à installer, sans friction.
                </p>
                <div class="space-y-3">
                    @php
                    $nfcFeatures = [
                        'Compatible tous smartphones (iPhone 7+ et Android)',
                        'Aucune application requise',
                        'URL permanente — changez de profil sans changer de carte',
                        'PVC premium, résistante à l\'eau et aux chocs',
                        'Design standard ou personnalisé (avec votre logo)',
                    ];
                    @endphp
                    @foreach($nfcFeatures as $feature)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm" style="color: #4B5563;">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    <a href="{{ url('/carte-nfc') }}" class="btn btn-primary" style="padding: 12px 24px; font-size: 14px; border-radius: 10px;">
                        En savoir plus sur la carte
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- QR CODE + CONNEXIONS --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 28px; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 30px rgba(66,181,116,0.12)'" onmouseout="this.style.boxShadow='none'">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #F0F9F4; color: #42B574;">03 — QR Code</div>
                <h3 class="text-xl font-bold mb-3" style="color: #2C2A27;">QR Code intégré</h3>
                <p class="text-sm leading-relaxed mb-4" style="color: #4B5563;">Pour ceux qui n'ont pas encore leur carte NFC. Partagez votre QR Code par email, dans vos présentations, ou affichez-le sur votre écran.</p>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color: #EFF6FF; color: #4A7FBF;">Disponible avec Pro et Premium</span>
            </div>
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 28px; transition: all 0.3s ease; transition-delay: 0.1s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(66,181,116,0.12)'" onmouseout="this.style.boxShadow='none'">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #F0F9F4; color: #42B574;">04 — Connexions</div>
                <h3 class="text-xl font-bold mb-3" style="color: #2C2A27;">Votre réseau se construit naturellement</h3>
                <p class="text-sm leading-relaxed mb-4" style="color: #4B5563;">Chaque scan crée une demande de connexion. Acceptez, refusez, gardez le contrôle. Accédez rapidement au téléphone et email de vos contacts.</p>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color: #F0F9F4; color: #42B574;">Inclus dans tous les forfaits</span>
            </div>
        </div>
    </div>
</section>

{{-- STATISTIQUES + TEMPLATES --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 28px; transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 8px 30px rgba(66,181,116,0.12)'" onmouseout="this.style.boxShadow='none'">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #EFF6FF; color: #4A7FBF;">05 — Statistiques</div>
                <h3 class="text-xl font-bold mb-3" style="color: #2C2A27;">Comprenez votre impact</h3>
                <p class="text-sm leading-relaxed mb-4" style="color: #4B5563;">Voyez combien de personnes consultent votre profil. Avec Pro, accédez aux vues quotidiennes et clics par lien. Avec Premium, géolocalisation, appareils et heures de pointe.</p>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color: #EFF6FF; color: #4A7FBF;">Selon votre forfait</span>
            </div>
            <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 32px 28px; transition: all 0.3s ease; transition-delay: 0.1s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(66,181,116,0.12)'" onmouseout="this.style.boxShadow='none'">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4" style="background-color: #F0F9F4; color: #42B574;">06 — Templates</div>
                <h3 class="text-xl font-bold mb-3" style="color: #2C2A27;">13 templates professionnels</h3>
                <p class="text-sm leading-relaxed mb-4" style="color: #4B5563;">Classique, Minimal, Diagonal, Split, Géométrique, Bold… et des templates spécialisés pour vidéastes, artistes et entrepreneurs. Changez de style en un clic.</p>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium" style="background-color: #F0F9F4; color: #42B574;">3 gratuits + 7 Pro + 2 Premium</span>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 sm:py-20" style="background: linear-gradient(135deg, #2C2A27 0%, #1A1918 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(66,181,116,0.15) 0%, transparent 70%); pointer-events: none;"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center relative z-10 fade-up">
        <h2 class="text-3xl sm:text-4xl font-bold text-white">Créez votre profil en <span style="color: #42B574;">2 minutes</span></h2>
        <p class="mt-4 text-base" style="color: #9CA3AF;">Gratuit pour commencer. Sans engagement. Sans carte de crédit.</p>
        <div class="mt-8">
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                Commencer gratuitement
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
