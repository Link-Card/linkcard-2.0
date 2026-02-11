@extends('layouts.public')

@section('title', 'LinkCard — Votre carte de visite. Repensée.')
@section('meta_description', 'Créez votre carte de visite digitale professionnelle et partagez votre profil en un geste avec la carte NFC LinkCard. Gratuit pour commencer.')

@section('styles')
<style>
    /* ============================================
       HERO
       ============================================ */
    .hero-gradient {
        background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #E8F5ED 70%, #F7F8F4 100%);
        position: relative;
        overflow: hidden;
    }
    .hero-gradient::before {
        content: '';
        position: absolute;
        top: -120px;
        right: -200px;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(66,181,116,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .hero-gradient::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -150px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(74,127,191,0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ============================================
       PHONE MOCKUP
       ============================================ */
    .phone-mockup {
        width: 260px;
        height: 520px;
        background: #1A1A1A;
        border-radius: 40px;
        padding: 12px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.15), 0 8px 20px rgba(0,0,0,0.1), inset 0 0 0 2px rgba(255,255,255,0.1);
        position: relative;
    }
    .phone-screen {
        width: 100%;
        height: 100%;
        border-radius: 28px;
        overflow: hidden;
        background: #FFFFFF;
    }
    .phone-notch {
        position: absolute;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 28px;
        background: #1A1A1A;
        border-radius: 0 0 18px 18px;
        z-index: 10;
    }
    .phone-profile-header {
        height: 180px;
        background: linear-gradient(135deg, #42B574, #3DA367);
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding-bottom: 16px;
    }
    .phone-profile-wave {
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
    }
    .phone-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 3px solid #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        z-index: 5;
    }
    .phone-name { color: #FFFFFF; font-size: 13px; font-weight: 600; margin-top: 6px; z-index: 5; }
    .phone-title { color: rgba(255,255,255,0.85); font-size: 10px; z-index: 5; }
    .phone-content { padding: 20px 16px; display: flex; flex-direction: column; gap: 8px; }
    .phone-btn {
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0 12px;
        font-size: 11px;
        font-weight: 500;
        gap: 8px;
    }
    .phone-social { background: #F3F4F6; color: #2C2A27; }
    .phone-cta-btn { background: #42B574; color: white; justify-content: center; font-weight: 600; }

    /* ============================================
       NFC CARD MOCKUP
       ============================================ */
    .nfc-card {
        width: 200px;
        height: 126px;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.12), 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .nfc-card-dark {
        background: linear-gradient(135deg, #2C2A27 0%, #1A1918 100%);
    }
    .nfc-card-dark::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle at top right, rgba(66,181,116,0.15), transparent 70%);
    }
    .nfc-card-text {
        font-size: 14px;
        font-weight: 700;
        letter-spacing: -0.02em;
    }
    .nfc-card-dark .nfc-card-text span:first-child { color: #42B574; }
    .nfc-card-dark .nfc-card-text span:last-child { color: #FFFFFF; }

    /* Hero floating card */
    .hero-card {
        position: absolute;
        bottom: 40px;
        left: -60px;
        transform: rotate(-12deg);
        animation: floatCard 6s ease-in-out infinite;
    }
    @keyframes floatCard {
        0%, 100% { transform: rotate(-12deg) translateY(0); }
        50% { transform: rotate(-12deg) translateY(-10px); }
    }

    /* ============================================
       TAP ANIMATION
       ============================================ */
    .tap-animation {
        position: relative;
        display: inline-flex;
    }
    .tap-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 2px solid rgba(66,181,116,0.3);
        animation: tapPulse 2.5s ease-out infinite;
    }
    .tap-ring:nth-child(2) { animation-delay: 0.5s; }
    .tap-ring:nth-child(3) { animation-delay: 1s; }
    @keyframes tapPulse {
        0% { width: 40px; height: 40px; opacity: 1; }
        100% { width: 140px; height: 140px; opacity: 0; }
    }

    /* ============================================
       PILLAR CARDS
       ============================================ */
    .pillar-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .pillar-card:hover {
        box-shadow: 0 8px 30px rgba(66,181,116,0.12);
        transform: translateY(-4px);
        border-color: rgba(66,181,116,0.3);
    }
    .pillar-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    /* ============================================
       BUNDLE CARDS
       ============================================ */
    .bundle-card {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 28px 24px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .bundle-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }
    .bundle-popular {
        border-color: #42B574;
        box-shadow: 0 4px 20px rgba(66,181,116,0.15);
    }
    .bundle-popular::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #42B574, #3DA367);
    }
    .bundle-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ============================================
       CTA SECTION
       ============================================ */
    .cta-section {
        background: linear-gradient(135deg, #2C2A27 0%, #1A1918 100%);
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(66,181,116,0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ============================================
       STEP NUMBER
       ============================================ */
    .step-number {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .phone-mockup { width: 220px; height: 440px; border-radius: 32px; padding: 10px; }
        .phone-screen { border-radius: 22px; }
        .phone-notch { width: 100px; height: 24px; border-radius: 0 0 14px 14px; }
        .phone-profile-header { height: 150px; }
        .hero-card {
            position: relative;
            bottom: auto;
            left: auto;
            transform: rotate(-6deg);
            margin-top: -20px;
        }
        .nfc-card { width: 170px; height: 107px; }
    }
</style>
@endsection

@section('content')

{{-- ============================================
     HERO
     ============================================ --}}
<section class="hero-gradient pt-24 sm:pt-32 pb-16 sm:pb-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            {{-- Text --}}
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight" style="color: #2C2A27;">
                    Votre carte de visite.<br>
                    <span style="color: #42B574;">Repensée.</span>
                </h1>
                <p class="mt-6 text-lg sm:text-xl leading-relaxed max-w-lg mx-auto lg:mx-0" style="color: #4B5563;">
                    La carte NFC qui connecte votre monde professionnel en un geste. Créez votre profil digital et partagez-le instantanément.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                        Commencer gratuitement
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ url('/carte-nfc') }}" class="btn btn-secondary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                        Voir la carte
                    </a>
                </div>
                <p class="mt-4 text-sm" style="color: #9CA3AF;">Gratuit pour toujours · Aucune carte de crédit requise</p>
            </div>

            {{-- Phone + Card mockup --}}
            <div class="flex-shrink-0 relative">
                <div class="phone-mockup">
                    <div class="phone-screen">
                        <div class="phone-notch"></div>
                        <div class="phone-profile-header">
                            <div class="phone-avatar">
                                <svg class="w-7 h-7" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                            </div>
                            <div class="phone-name">Marie Tremblay</div>
                            <div class="phone-title">Consultante Marketing</div>
                            <svg class="phone-profile-wave" viewBox="0 0 236 20" fill="white" preserveAspectRatio="none" style="height: 20px;">
                                <path d="M0 20 Q59 0 118 10 Q177 20 236 5 L236 20 Z"/>
                            </svg>
                        </div>
                        <div class="phone-content">
                            <div class="phone-btn phone-cta-btn">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                                Ajouter au contact
                            </div>
                            <div class="phone-btn phone-social">
                                <svg class="w-3.5 h-3.5" fill="#0A66C2" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </div>
                            <div class="phone-btn phone-social">
                                <svg class="w-3.5 h-3.5" fill="#E4405F" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                Instagram
                            </div>
                            <div class="phone-btn phone-social">
                                <svg class="w-3.5 h-3.5" fill="#2C2A27" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                Portfolio
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Floating NFC Card --}}
                <div class="hero-card">
                    <div class="nfc-card-dark nfc-card">
                        <svg viewBox="0 0 40 40" fill="none" style="width: 36px; height: 36px;">
                            <path d="M12 20c0-4.4 3.6-8 8-8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/>
                            <path d="M28 20c0 4.4-3.6 8-8 8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/>
                            <circle cx="16" cy="20" r="4" fill="#42B574" opacity="0.3"/>
                            <circle cx="24" cy="20" r="4" fill="#42B574" opacity="0.3"/>
                        </svg>
                        <div class="nfc-card-text mt-1">
                            <span>LINK</span><span>CARD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     3 PILIERS
     ============================================ --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Tout ce qu'il faut pour connecter</h2>
            <p class="mt-4 text-lg max-w-2xl mx-auto" style="color: #4B5563;">Un profil professionnel, une carte intelligente, un réseau qui grandit.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="pillar-card fade-up">
                <div class="pillar-icon" style="background-color: #F0F9F4;">
                    <svg class="w-7 h-7" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3" style="color: #2C2A27;">Profil digital</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Créez votre carte de visite digitale en 2 minutes. Photo, liens sociaux, texte, images — avec 13 templates au choix.</p>
            </div>
            <div class="pillar-card fade-up" style="transition-delay: 0.1s;">
                <div class="pillar-icon" style="background-color: #F0F9F4;">
                    <svg class="w-7 h-7" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0"/><circle cx="12" cy="18.75" r="0.75" fill="#42B574"/></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3" style="color: #2C2A27;">Carte NFC</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Un geste suffit pour partager votre profil. Compatible avec tous les smartphones modernes, aucune app requise.</p>
            </div>
            <div class="pillar-card fade-up" style="transition-delay: 0.2s;">
                <div class="pillar-icon" style="background-color: #F0F9F4;">
                    <svg class="w-7 h-7" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                </div>
                <h3 class="text-xl font-semibold mb-3" style="color: #2C2A27;">Connexions</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Votre réseau professionnel se construit naturellement. Chaque scan crée une connexion, chaque contact est sauvegardé.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     DÉMO NFC
     ============================================ --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <div class="flex-1 flex justify-center fade-up">
                <div class="relative">
                    <div class="tap-animation" style="width: 240px; height: 240px; display: flex; align-items: center; justify-content: center;">
                        <div class="tap-ring"></div>
                        <div class="tap-ring"></div>
                        <div class="tap-ring"></div>
                        <div class="nfc-card-dark nfc-card" style="width: 160px; height: 100px; position: relative; z-index: 5;">
                            <svg viewBox="0 0 40 40" fill="none" style="width: 28px; height: 28px;">
                                <path d="M12 20c0-4.4 3.6-8 8-8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/>
                                <path d="M28 20c0 4.4-3.6 8-8 8" stroke="#42B574" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="16" cy="20" r="4" fill="#42B574" opacity="0.3"/>
                                <circle cx="24" cy="20" r="4" fill="#42B574" opacity="0.3"/>
                            </svg>
                            <div class="nfc-card-text" style="font-size: 11px;">
                                <span>LINK</span><span>CARD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 fade-up">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-6" style="background-color: #F0F9F4; color: #42B574;">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                    L'expérience NFC
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold mb-6" style="color: #2C2A27;">
                    Touchez. Connectez.<br><span style="color: #42B574;">C'est tout.</span>
                </h2>
                <p class="text-lg leading-relaxed mb-8" style="color: #4B5563;">
                    Approchez votre carte du téléphone de votre interlocuteur. Votre profil s'ouvre instantanément — sans application, sans QR Code.
                </p>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="step-number" style="background-color: #F0F9F4; color: #42B574;">1</div>
                        <div>
                            <p class="font-semibold text-sm" style="color: #2C2A27;">Approchez votre carte</p>
                            <p class="text-sm mt-1" style="color: #4B5563;">Un simple geste, comme un paiement sans contact.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="step-number" style="background-color: #F0F9F4; color: #42B574;">2</div>
                        <div>
                            <p class="font-semibold text-sm" style="color: #2C2A27;">Votre profil s'affiche</p>
                            <p class="text-sm mt-1" style="color: #4B5563;">Le navigateur s'ouvre automatiquement avec toutes vos informations.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="step-number" style="background-color: #F0F9F4; color: #42B574;">3</div>
                        <div>
                            <p class="font-semibold text-sm" style="color: #2C2A27;">La connexion est créée</p>
                            <p class="text-sm mt-1" style="color: #4B5563;">Votre contact peut vous ajouter en un clic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     COMPARAISON
     ============================================ --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">La dernière carte de visite<br>que vous aurez à imprimer</h2>
        </div>
        <div class="fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; overflow: hidden;">
            <div class="grid grid-cols-3 text-center text-sm font-semibold" style="background-color: #F7F8F4; border-bottom: 1px solid #E5E7EB;">
                <div class="py-4 px-3"></div>
                <div class="py-4 px-3" style="color: #9CA3AF;">Carte papier</div>
                <div class="py-4 px-3" style="color: #42B574;">LinkCard</div>
            </div>
            @php
            $comparisons = [
                ['label' => 'Après un événement', 'paper' => 'Jetée ou perdue', 'link' => 'Toujours accessible'],
                ['label' => 'Mise à jour', 'paper' => 'Réimpression complète', 'link' => 'Modifiable en temps réel'],
                ['label' => 'Suivi des contacts', 'paper' => 'Aucun', 'link' => 'Statistiques de scan'],
                ['label' => 'Environnement', 'paper' => 'Papier + encre', 'link' => 'Réutilisable à l\'infini'],
                ['label' => 'Coût long terme', 'paper' => '500 cartes = 80$+', 'link' => '1 carte = pour toujours'],
            ];
            @endphp
            @foreach($comparisons as $row)
            <div class="grid grid-cols-3 items-center text-sm" style="{{ !$loop->last ? 'border-bottom: 1px solid #F3F4F6;' : '' }}">
                <div class="py-3.5 px-3 sm:px-6 font-medium text-xs sm:text-sm" style="color: #2C2A27;">{{ $row['label'] }}</div>
                <div class="py-3.5 px-3 text-center flex items-center justify-center gap-1.5" style="color: #9CA3AF;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#EF4444" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span class="hidden sm:inline text-xs">{{ $row['paper'] }}</span>
                </div>
                <div class="py-3.5 px-3 text-center flex items-center justify-center gap-1.5" style="color: #2C2A27;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    <span class="hidden sm:inline text-xs">{{ $row['link'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================
     BUNDLES DE LANCEMENT
     ============================================ --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-6 fade-up">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold" style="background: linear-gradient(135deg, #42B574, #3DA367); color: white;">
                🚀 Offre de lancement — Places limitées
            </span>
        </div>
        <div class="text-center mb-12 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: #2C2A27;">Démarrez avec tout ce qu'il faut</h2>
            <p class="mt-4 text-lg max-w-2xl mx-auto" style="color: #4B5563;">Carte NFC + abonnement Premium. Tout est inclus pour faire une première impression mémorable.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {{-- Découverte --}}
            <div class="bundle-card fade-up">
                <h3 class="text-lg font-bold mb-1" style="color: #2C2A27;">Découverte</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">L'essentiel pour commencer</p>
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
                </ul>
                <a href="{{ route('register') }}" class="btn btn-secondary w-full" style="border-radius: 10px;">Choisir</a>
            </div>
            {{-- Pro (populaire) --}}
            <div class="bundle-card bundle-popular fade-up" style="transition-delay: 0.1s;">
                <div class="bundle-badge" style="background-color: #F0F9F4; color: #42B574;">Populaire ⭐</div>
                <h3 class="text-lg font-bold mb-1" style="color: #2C2A27;">Pro</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">Le choix des professionnels</p>
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
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary w-full" style="border-radius: 10px;">Choisir</a>
            </div>
            {{-- Duo --}}
            <div class="bundle-card fade-up" style="transition-delay: 0.2s;">
                <div class="bundle-badge" style="background-color: #FEF3C7; color: #92400E;">Meilleur deal</div>
                <h3 class="text-lg font-bold mb-1" style="color: #2C2A27;">Duo</h3>
                <p class="text-sm mb-5" style="color: #9CA3AF;">Pour ceux qui veulent tout</p>
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
                </ul>
                <a href="{{ route('register') }}" class="btn btn-secondary w-full" style="border-radius: 10px;">Choisir</a>
            </div>
        </div>
        <div class="text-center mt-8 fade-up">
            <p class="text-sm" style="color: #9CA3AF;">Après la période incluse : Premium continue à 8$/mois, annulable en tout temps.</p>
            <a href="{{ url('/forfaits') }}" class="inline-flex items-center text-sm font-medium mt-2" style="color: #42B574;">
                Voir tous les forfaits
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================
     2e PROFIL OFFERT
     ============================================ --}}
<section class="py-10" style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="fade-up" style="background: linear-gradient(135deg, #F0F9F4 0%, #EFF6FF 100%); border-radius: 16px; padding: 24px 28px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center; text-align: center;">
            <span class="text-2xl">🎁</span>
            <p class="text-sm sm:text-base font-medium" style="color: #2C2A27;">
                <strong>Offre de lancement :</strong> 2e profil offert pour les 250 premiers inscrits
            </p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="border-radius: 8px;">En profiter</a>
        </div>
    </div>
</section>

{{-- ============================================
     CTA FINAL
     ============================================ --}}
<section class="cta-section py-20 sm:py-28">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center relative z-10">
        <div class="fade-up">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                Prêt à faire une première<br>impression <span style="color: #42B574;">durable</span>?
            </h2>
            <p class="mt-6 text-lg" style="color: #9CA3AF;">Rejoignez les professionnels qui ont déjà repensé leur façon de se connecter.</p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 16px 32px; font-size: 16px; border-radius: 12px;">
                    Créer mon profil gratuitement
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <p class="mt-4 text-sm" style="color: #6B7280;">Gratuit · Sans engagement · Prêt en 2 minutes</p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Reinit fade-up observer on DOMContentLoaded (safety net)
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-up:not(.visible)');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endsection
