<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27; letter-spacing: -0.02em;">
                Bienvenue, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="mt-2 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                Ravi de vous revoir sur Link-Card. Voici un aperçu de votre compte.
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            
            <!-- Plan Actuel -->
            <div class="bg-white rounded-xl border p-6 transition-all duration-200" 
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Plan Actuel</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #EFF6FF;">
                        <svg class="w-5 h-5" fill="none" stroke="#4A7FBF" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ ((Auth::user()->plan ?? 'free') === 'free') ? 'GRATUIT' : strtoupper(Auth::user()->plan) }}
                </p>
            </div>

            <!-- Profils -->
            <div class="bg-white rounded-xl border p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Profils</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #F0F9F4;">
                        <svg class="w-5 h-5" fill="none" stroke="#42B574" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ Auth::user()->profiles->count() }}
                </p>
            </div>

            <!-- Cartes NFC -->
            <div class="bg-white rounded-xl border p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Cartes NFC</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #F3F0FF;">
                        <svg class="w-5 h-5" fill="none" stroke="#8B5CF6" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">0</p>
            </div>

            <!-- Vues Totales -->
            <div class="bg-white rounded-xl border p-6 transition-all duration-200"
                 style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);"
                 onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Vues Totales</span>
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: #FFF1F2;">
                        <svg class="w-5 h-5" fill="none" stroke="#E11D48" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">0</p>
            </div>
        </div>

        <!-- Actions Rapides -->
        <div class="bg-white rounded-xl border p-6" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h2 class="text-lg font-semibold mb-4" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Actions Rapides</h2>
            <div class="grid gap-4 md:grid-cols-2">
                
                <a href="{{ route('profile.create') }}" 
                   class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                   style="border-color: #D1D5DB;"
                   onmouseover="this.style.borderColor='#42B574'; this.style.background='#F0F9F4'"
                   onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #F0F9F4;">
                        <i class="fas fa-plus text-2xl" style="color: #42B574;"></i>
                    </div>
                    <div>
                        <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Créer un profil</p>
                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Nouveau profil Link-Card</p>
                    </div>
                </a>

                <a href="#" 
                   class="flex items-center space-x-4 p-4 rounded-lg border-2 border-dashed transition-all duration-200"
                   style="border-color: #D1D5DB;"
                   onmouseover="this.style.borderColor='#4A7FBF'; this.style.background='#EFF6FF'"
                   onmouseout="this.style.borderColor='#D1D5DB'; this.style.background='transparent'">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: #EFF6FF;">
                        <i class="fas fa-credit-card text-2xl" style="color: #4A7FBF;"></i>
                    </div>
                    <div>
                        <p class="font-medium" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Commander une carte</p>
                        <p class="text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">Carte NFC physique</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
