<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <title>Carte désactivée - Link-Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="font-family: 'Manrope', sans-serif; background-color: #F7F8F4;" class="min-h-screen flex items-center justify-center">
    <div class="text-center px-6">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
            <svg class="w-10 h-10" style="color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-semibold mb-2" style="color: #2C2A27;">Carte désactivée</h1>
        <p class="mb-6" style="color: #4B5563;">Le propriétaire a temporairement désactivé cette carte.</p>
        <a href="/" class="inline-block px-6 py-3 rounded-lg text-white font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
            Retour à l'accueil
        </a>
        <div class="mt-8">
            <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-8 mx-auto opacity-40">
        </div>
    </div>
</body>
</html>
