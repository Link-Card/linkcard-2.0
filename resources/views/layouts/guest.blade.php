<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Link-Card') }}</title>

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
    <div class="min-h-screen">
        {{ $slot }}
    </div>
    
    @livewireScripts
</body>
</html>
