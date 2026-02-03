<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-color: var(--link-white, #F7F8F4);">
    <div class="max-w-md w-full">
        
        <!-- Logo + Titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background: linear-gradient(135deg, #4A7FBF 0%, #42B574 100%);">
                <span class="text-white font-semibold text-xl" style="font-family: 'Manrope', sans-serif;">LC</span>
            </div>
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Connexion</h1>
            <p class="mt-2 text-sm" style="color: #4B5563;">
                Accédez à votre compte Link-Card
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-sm border p-8" style="border-color: #E5E7EB;">
            
            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg text-sm" style="background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form wire:submit.prevent="login" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Adresse email</label>
                    <input wire:model="email" id="email" name="email" type="email" 
                        class="w-full px-4 py-3 rounded-lg text-sm transition-all duration-200 outline-none" 
                        style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; color: #2C2A27;"
                        onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                        onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                        placeholder="email@exemple.com">
                    @error('email') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium uppercase tracking-wider mb-2" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Mot de passe</label>
                    <input wire:model="password" id="password" name="password" type="password" 
                        class="w-full px-4 py-3 rounded-lg text-sm transition-all duration-200 outline-none"
                        style="font-family: 'Manrope', sans-serif; border: 1.5px solid #D1D5DB; color: #2C2A27;"
                        onfocus="this.style.borderColor='#42B574'; this.style.boxShadow='0 0 0 3px #F0F9F4'"
                        onblur="this.style.borderColor='#D1D5DB'; this.style.boxShadow='none'"
                        placeholder="••••••••">
                    @error('password') <span class="text-xs mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 rounded" style="accent-color: #42B574;">
                        <label for="remember" class="ml-2 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium transition-colors" style="font-family: 'Manrope', sans-serif; color: #42B574;">
                        Mot de passe oublié?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" 
                    class="w-full py-3 px-4 text-sm font-medium text-white rounded-lg transition-all duration-200 shadow-sm"
                    style="font-family: 'Manrope', sans-serif; background: #42B574;"
                    onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'"
                    onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'">
                    Se connecter
                </button>
            </form>
        </div>

        <!-- Register link -->
        <p class="text-center text-sm mt-6" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-medium" style="color: #42B574;">
                Créer un compte
            </a>
        </p>
    </div>
</div>
