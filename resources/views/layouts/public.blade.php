<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Link-Card — Votre carte de visite digitale')</title>
    <meta name="description" content="@yield('meta_description', 'Créez votre carte de visite digitale professionnelle. Partagez votre profil en un geste avec la carte NFC Link-Card.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Link-Card — Votre carte de visite digitale')">
    <meta property="og:description" content="@yield('meta_description', 'Créez votre carte de visite digitale professionnelle. Partagez votre profil en un geste avec la carte NFC Link-Card.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Manrope Font (Brand Book) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <style>
        /* ============================================
           PUBLIC LAYOUT STYLES
           ============================================ */

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Scroll animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Nav blur on scroll */
        .nav-scrolled {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        /* Mobile menu */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-menu.open {
            max-height: 400px;
        }

        /* Footer link hover */
        .footer-link {
            color: #9CA3AF;
            transition: color 0.2s ease;
        }
        .footer-link:hover {
            color: #42B574;
        }

        @yield('styles')
    </style>
</head>
<body class="antialiased" style="font-family: 'Manrope', system-ui, sans-serif; background-color: #F7F8F4; color: #2C2A27;">

    {{-- ============================================
         NAVIGATION
         ============================================ --}}
    <nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" style="background: transparent;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                {{-- Logo --}}
                <a href="/" class="flex items-center space-x-2 flex-shrink-0">
                    <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-7 sm:h-8 w-auto">
                    <span class="font-semibold text-lg hidden sm:inline" style="color: #2C2A27;">Link-Card</span>
                </a>

                {{-- Desktop links --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/fonctionnalites') }}" class="text-sm font-medium transition-colors duration-200" style="color: #4B5563;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#4B5563'">Fonctionnalités</a>
                    <a href="{{ url('/carte-nfc') }}" class="text-sm font-medium transition-colors duration-200" style="color: #4B5563;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#4B5563'">Carte NFC</a>
                    <a href="{{ url('/forfaits') }}" class="text-sm font-medium transition-colors duration-200" style="color: #4B5563;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#4B5563'">Forfaits</a>
                    <a href="{{ url('/faq') }}" class="text-sm font-medium transition-colors duration-200" style="color: #4B5563;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#4B5563'">FAQ</a>
                </div>

                {{-- CTA buttons --}}
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 14px;">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium" style="color: #4B5563;">Se connecter</a>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 14px;">
                            Commencer
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endauth
                </div>

                {{-- Mobile hamburger --}}
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg" style="color: #2C2A27;" aria-label="Menu">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile menu --}}
            <div id="mobileMenu" class="mobile-menu md:hidden" style="border-top: 1px solid #E5E7EB;">
                <div class="py-4 space-y-1">
                    <a href="{{ url('/fonctionnalites') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg" style="color: #4B5563;">Fonctionnalités</a>
                    <a href="{{ url('/carte-nfc') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg" style="color: #4B5563;">Carte NFC</a>
                    <a href="{{ url('/forfaits') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg" style="color: #4B5563;">Forfaits</a>
                    <a href="{{ url('/faq') }}" class="block px-3 py-2.5 text-sm font-medium rounded-lg" style="color: #4B5563;">FAQ</a>
                    <div class="pt-3 space-y-2" style="border-top: 1px solid #E5E7EB;">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary w-full" style="font-size: 14px;">Tableau de bord</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2.5 text-sm font-medium text-center rounded-lg" style="color: #4B5563;">Se connecter</a>
                            <a href="{{ route('register') }}" class="btn btn-primary w-full" style="font-size: 14px;">Commencer gratuitement</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
    <main>
        @yield('content')
    </main>

    {{-- ============================================
         FOOTER
         ============================================ --}}
    <footer style="background-color: #2C2A27; color: #FFFFFF;">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 sm:gap-12">
                {{-- Brand --}}
                <div class="col-span-2 sm:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('images/logo-blanc.png') }}" alt="Link-Card" class="h-7 w-auto">
                        <span class="font-semibold text-lg text-white">Link-Card</span>
                    </div>
                    <p class="text-sm leading-relaxed" style="color: #9CA3AF;">
                        Transformer chaque rencontre en connexion durable.
                    </p>
                </div>

                {{-- Produit --}}
                <div>
                    <h4 class="font-semibold text-sm mb-4 text-white">Produit</h4>
                    <nav class="space-y-2.5">
                        <a href="{{ url('/fonctionnalites') }}" class="block text-sm footer-link">Fonctionnalités</a>
                        <a href="{{ url('/carte-nfc') }}" class="block text-sm footer-link">Carte NFC</a>
                        <a href="{{ url('/forfaits') }}" class="block text-sm footer-link">Forfaits</a>
                        <a href="{{ url('/a-propos') }}" class="block text-sm footer-link">À propos</a>
                    </nav>
                </div>

                {{-- Ressources --}}
                <div>
                    <h4 class="font-semibold text-sm mb-4 text-white">Ressources</h4>
                    <nav class="space-y-2.5">
                        <a href="{{ url('/faq') }}" class="block text-sm footer-link">FAQ</a>
                        <a href="{{ url('/contact') }}" class="block text-sm footer-link">Nous contacter</a>
                        <a href="mailto:support@linkcard.ca" class="block text-sm footer-link">support@linkcard.ca</a>
                    </nav>
                </div>

                {{-- Légal --}}
                <div>
                    <h4 class="font-semibold text-sm mb-4 text-white">Légal</h4>
                    <nav class="space-y-2.5">
                        <a href="{{ route('legal.terms') }}" class="block text-sm footer-link">Conditions d'utilisation</a>
                        <a href="{{ route('legal.privacy') }}" class="block text-sm footer-link">Confidentialité</a>
                        <a href="{{ route('legal.refund') }}" class="block text-sm footer-link">Remboursement</a>
                    </nav>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="text-xs" style="color: #6B7280;">
                    © {{ date('Y') }} Link-Card · Mauricie, QC
                </p>
                <div class="flex items-center space-x-4">
                    {{-- LinkedIn --}}
                    <a href="#" class="transition-colors duration-200" style="color: #6B7280;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#6B7280'" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="#" class="transition-colors duration-200" style="color: #6B7280;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#6B7280'" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    {{-- Facebook --}}
                    <a href="#" class="transition-colors duration-200" style="color: #6B7280;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#6B7280'" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ============================================
         SCRIPTS
         ============================================ --}}
    <script>
        // Nav scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });
        // Apply on load too
        if (window.scrollY > 50) nav.classList.add('nav-scrolled');

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');
            menu.classList.toggle('open');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        // Fade-in on scroll (IntersectionObserver)
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        fadeElements.forEach(el => observer.observe(el));
    </script>

    @yield('scripts')
</body>
</html>
