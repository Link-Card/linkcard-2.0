<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Link-Card') }}</title>

    <!-- Favicon Link-Card -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Manrope Font (Brand Book) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Design System -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    
    @livewireStyles
</head>
<body class="antialiased" style="font-family: 'Manrope', system-ui, sans-serif; background-color: #F7F8F4;">
    <div class="min-h-screen flex flex-col">
        <div class="flex-1">
            {{ $slot }}
        </div>
        <footer class="py-6" style="border-top: 1px solid #E5E7EB;">
            <div class="max-w-md mx-auto px-4 flex flex-col items-center gap-3">
                <nav class="flex items-center flex-wrap justify-center gap-x-4 gap-y-1 text-xs" style="color: #9CA3AF;">
                    <a href="{{ route('legal.terms') }}" class="hover:underline">Conditions</a>
                    <a href="{{ route('legal.privacy') }}" class="hover:underline">Confidentialité</a>
                    <a href="{{ route('legal.refund') }}" class="hover:underline">Remboursement</a>
                </nav>
                <span class="text-xs" style="color: #D1D5DB;">© {{ date('Y') }} Link-Card</span>
            </div>
        </footer>
    </div>
    
    @livewireScripts
</body>
</html>
