<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        @if($verified)
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Email vérifié avec succès!
                </h2>
                
                <p class="mt-2 text-center text-sm text-gray-600">
                    Votre compte est maintenant activé.
                </p>
                
                <div class="mt-8">
                    <a href="{{ route('dashboard') }}" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Aller au dashboard
                    </a>
                </div>
            </div>
        @endif
        
        @if($error)
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Lien invalide
                </h2>
                
                <p class="mt-2 text-center text-sm text-gray-600">
                    Ce lien de vérification est invalide ou a expiré.
                </p>
                
                <div class="mt-8">
                    <a href="{{ route('verification.notice') }}" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Renvoyer l'email
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
