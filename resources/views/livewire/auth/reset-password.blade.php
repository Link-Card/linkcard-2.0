<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--link-white, #F7F8F4);">
    <div class="max-w-md w-full">
        
        <!-- Logo + Titre -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Link-Card" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Nouveau mot de passe</h1>
            <p class="mt-2 text-sm" style="color: #4B5563;">
                Choisissez votre nouveau mot de passe.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm border p-8" style="border-color: #E5E7EB;">
            
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg text-sm" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form wire:submit.prevent="resetPassword" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Adresse email</label>
                    <input wire:model="email" id="email" name="email" type="email" 
                        class="w-full px-4 py-3 rounded-lg text-sm transition-all duration-200 outline-none" 
                        style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; color: #2C2A27;"
                        onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                        onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                        placeholder="email@exemple.com"
                        required>
                    @error('email') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nouveau mot de passe</label>
                    <input wire:model="password" id="password" name="password" type="password" 
                        class="w-full px-4 py-3 rounded-lg text-sm transition-all duration-200 outline-none"
                        style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; color: #2C2A27;"
                        onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                        onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                        placeholder="••••••••"
                        required>
                    <p class="text-xs mt-1" style="color: #9CA3AF;">Min. 8 caractères, 1 majuscule, 1 chiffre, 1 spécial</p>
                    @error('password') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Confirmer le mot de passe</label>
                    <input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" 
                        class="w-full px-4 py-3 rounded-lg text-sm transition-all duration-200 outline-none"
                        style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; color: #2C2A27;"
                        onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                        onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                        placeholder="••••••••"
                        required>
                    @error('password_confirmation') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>

                <!-- Submit -->
                <button type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm disabled:opacity-60"
                    style="font-family: 'Manrope', sans-serif; background: #42B574;"
                    onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'"
                    onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    <span wire:loading.remove>Réinitialiser le mot de passe</span>
                    <span wire:loading class="flex items-center justify-center">
                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Réinitialisation...
                    </span>
                </button>
            </form>
        </div>

        <!-- Back to login -->
        <p class="text-center text-sm mt-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
            <a href="{{ route('login') }}" class="font-medium inline-flex items-center" style="color: #42B574;">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour à la connexion
            </a>
        </p>
    </div>
</div>
