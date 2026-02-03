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
                        <span class="text-lg">📊</span>
                    </div>
                </div>
                <p class="text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                    {{ strtoupper(Auth::user()->plan ?? 'FREE') }}
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
                        <span class="text-lg">👤</span>
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
                        <span class="text-lg">💳</span>
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
                        <span class="text-lg">👁️</span>
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
                        <span class="text-2xl">➕</span>
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
                        <span class="text-2xl">💳</span>
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
