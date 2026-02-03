<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--link-white, #F7F8F4);">
    <div class="max-w-md w-full">
        
        <!-- Logo + Titre -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Link-Card" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Vérifiez votre email</h1>
            <p class="mt-2 text-sm" style="color: #4B5563;">
                Merci pour votre inscription!
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm border p-8" style="border-color: #E5E7EB;">
            
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            @endif

            <!-- Message -->
            <div class="text-center mb-6">
                <!-- Email icon -->
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background: #F0F9F4;">
                    <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                <p class="text-sm mb-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    Avant de continuer, veuillez vérifier votre boîte de réception et cliquer sur le lien de vérification.
                </p>
                <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                    Si vous n'avez pas reçu l'email, cliquez ci-dessous pour en recevoir un nouveau.
                </p>
            </div>

            <!-- Resend -->
            <form wire:submit.prevent="sendVerification">
                <button type="submit" 
                    class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm"
                    style="font-family: 'Manrope', sans-serif; background: #42B574;"
                    onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'"
                    onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    Renvoyer l'email de vérification
                </button>
            </form>

            <!-- Logout -->
            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; color: #42B574;">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
