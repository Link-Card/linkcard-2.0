<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link-Card 2.0 - Test Livewire</title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            900: '#1A5233',
                            800: '#2D7A4F',
                            700: '#3D9B5F',
                            600: '#4FB577',
                            500: '#66CC8A',
                            400: '#85D9A3',
                        },
                        accent: '#00FF85',
                    }
                }
            }
        }
    </script>
    
    @livewireStyles
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-12">
        @livewire('counter')
    </div>
    
    @livewireScripts
</body>
</html>
