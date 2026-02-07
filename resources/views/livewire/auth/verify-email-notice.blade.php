<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--link-white, #F7F8F4);">
    <div class="max-w-md w-full">
        
        <!-- Logo + Titre -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-24 w-auto mx-auto mb-6">
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Vérifiez votre email</h1>
            <p class="mt-2 text-sm" style="color: #4B5563;">
                Un code à 6 chiffres a été envoyé à <strong>{{ auth()->user()->email }}</strong>
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm border p-8" style="border-color: #E5E7EB;">
            
            <!-- Icône email -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                    <svg class="w-8 h-8" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            @if ($resent)
                <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                    ✓ Un nouveau code a été envoyé!
                </div>
            @endif

            @if ($codeError)
                <div class="mb-6 p-4 rounded-lg text-sm" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ $codeError }}
                </div>
            @endif

            <!-- Code input -->
            <div class="mb-6">
                <label class="block text-xs font-medium uppercase tracking-wider mb-2 text-center" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Code de vérification</label>
                <input wire:model="code" 
                    wire:keydown.enter="verifyCode"
                    type="text" 
                    inputmode="numeric" 
                    maxlength="6" 
                    placeholder="000000"
                    autocomplete="one-time-code"
                    class="w-full text-center text-3xl font-bold py-4 rounded-xl transition-all duration-200 outline-none"
                    style="font-family: 'Courier New', monospace; border: 2px solid #D1D5DB; color: #2C2A27; letter-spacing: 0.5em;"
                    onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                    onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                    autofocus>
            </div>

            <!-- Verify button -->
            <button wire:click="verifyCode"
                wire:loading.attr="disabled"
                class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm disabled:opacity-60"
                style="font-family: 'Manrope', sans-serif; background: #42B574;"
                onmouseover="this.style.background='#3DA367'"
                onmouseout="this.style.background='#42B574'">
                <span wire:loading.remove wire:target="verifyCode">Vérifier</span>
                <span wire:loading wire:target="verifyCode" class="flex items-center justify-center">
                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    Vérification...
                </span>
            </button>

            <div class="text-center mt-6">
                <p class="text-xs mb-3" style="color: #9CA3AF;">Vous n'avez pas reçu le code?</p>
                <button wire:click="resendVerificationEmail"
                    wire:loading.attr="disabled"
                    class="text-sm font-medium transition-colors disabled:opacity-60"
                    style="font-family: 'Manrope', sans-serif; color: #42B574;">
                    <span wire:loading.remove wire:target="resendVerificationEmail">Renvoyer le code</span>
                    <span wire:loading wire:target="resendVerificationEmail">
                        <svg class="animate-spin h-4 w-4 mr-1 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Envoi...
                    </span>
                </button>
            </div>

            <!-- Logout -->
            <div class="text-center mt-4 pt-4" style="border-top: 1px solid #E5E7EB;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs" style="font-family: 'Manrope', sans-serif; color: #9CA3AF;">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
