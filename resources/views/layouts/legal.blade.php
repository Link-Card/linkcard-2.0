<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Link-Card</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Manrope', system-ui, sans-serif; }
        .legal-content h2 { font-size: 20px; font-weight: 600; color: #2C2A27; margin-top: 32px; margin-bottom: 12px; }
        .legal-content h3 { font-size: 16px; font-weight: 600; color: #2C2A27; margin-top: 24px; margin-bottom: 8px; }
        .legal-content p { font-size: 14px; color: #4B5563; line-height: 1.7; margin-bottom: 12px; }
        .legal-content ul { list-style: disc; padding-left: 24px; margin-bottom: 12px; }
        .legal-content ul li { font-size: 14px; color: #4B5563; line-height: 1.7; margin-bottom: 4px; }
        .legal-content a { color: #42B574; text-decoration: underline; }
    </style>
</head>
<body style="background-color: #F7F8F4;">
    {{-- Header --}}
    <header class="sticky top-0 z-50 bg-white shadow-sm" style="border-bottom: 1px solid #E5E7EB;">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-8 w-auto">
                <span class="font-semibold text-lg" style="color: #2C2A27;">Link-Card</span>
            </a>
            <div class="flex items-center space-x-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="font-medium" style="color: #42B574;">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" style="color: #4B5563;">Connexion</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-white text-sm font-medium" style="background-color: #42B574;">S'inscrire</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Content --}}
    <main class="max-w-3xl mx-auto px-4 py-8 sm:py-12">
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-10" style="border: 1px solid #E5E7EB;">
            <h1 class="text-2xl sm:text-3xl font-semibold mb-2" style="color: #2C2A27;">@yield('title')</h1>
            <p class="text-sm mb-8" style="color: #9CA3AF;">Dernière mise à jour : @yield('date')</p>
            
            <div class="legal-content">
                @yield('content')
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.legal-footer')
</body>
</html>
