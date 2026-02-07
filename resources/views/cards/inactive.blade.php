<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte désactivée - Link-Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Manrope', sans-serif; }</style>
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #F7F8F4;">
    <div class="max-w-md mx-auto px-6 text-center">
        {{-- Logo --}}
        <div class="mb-8">
            <a href="/">
                <img src="/vendor/logo_final_blanc.png" alt="Link-Card" class="h-12 mx-auto" onerror="this.style.display='none'">
            </a>
        </div>

        {{-- Icône --}}
        <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
            <svg class="w-10 h-10" style="color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>

        <h1 class="text-2xl font-semibold mb-3" style="color: #2C2A27;">Carte désactivée</h1>
        <p class="text-base mb-8" style="color: #4B5563;">
            Le propriétaire de cette carte l'a temporairement désactivée. Elle sera de nouveau accessible lorsqu'il la réactivera.
        </p>

        <a href="/" class="inline-block px-6 py-3 rounded-lg text-white font-medium transition-colors" 
           style="background-color: #42B574;"
           onmouseover="this.style.backgroundColor='#3DA367'" 
           onmouseout="this.style.backgroundColor='#42B574'">
            Découvrir Link-Card
        </a>
    </div>
</body>
</html>
