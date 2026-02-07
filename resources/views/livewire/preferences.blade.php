<div class="py-6 sm:py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-semibold" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">Préférences</h1>
            <p class="mt-1 text-sm" style="font-family: 'Manrope', sans-serif; color: #4B5563;">
                Gérez vos notifications et paramètres
            </p>
        </div>

        @if(session()->has('message'))
            <div class="mb-6 p-4 rounded-lg text-sm font-medium" style="background: #F0F9F4; border: 1px solid #7EE081; color: #2C2A27;">
                {{ session('message') }}
            </div>
        @endif

        <!-- Notifications email -->
        <div class="bg-white rounded-xl border p-5 sm:p-6" style="border-color: #E5E7EB; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h2 class="text-base font-semibold mb-4 flex items-center gap-2" style="font-family: 'Manrope', sans-serif; color: #2C2A27;">
                <svg class="w-5 h-5" fill="none" stroke="#4B5563" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                Notifications email
            </h2>

            <div class="space-y-4">
                <!-- Toggle demande reçue -->
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <p class="text-sm font-medium" style="color: #2C2A27;">Nouvelle demande de connexion</p>
                        <p class="text-xs" style="color: #9CA3AF;">Recevoir un email quand quelqu'un veut se connecter</p>
                    </div>
                    <div class="relative">
                        <input type="checkbox" wire:model.live="notifyConnectionRequest" class="sr-only peer">
                        <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"
                             style="background: {{ $notifyConnectionRequest ? '#42B574' : '#D1D5DB' }};">
                        </div>
                    </div>
                </label>

                <div style="border-top: 1px solid #E5E7EB;"></div>

                <!-- Toggle demande acceptée -->
                <label class="flex items-center justify-between cursor-pointer">
                    <div>
                        <p class="text-sm font-medium" style="color: #2C2A27;">Demande acceptée</p>
                        <p class="text-xs" style="color: #9CA3AF;">Recevoir un email quand votre demande est acceptée</p>
                    </div>
                    <div class="relative">
                        <input type="checkbox" wire:model.live="notifyConnectionAccepted" class="sr-only peer">
                        <div class="w-11 h-6 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"
                             style="background: {{ $notifyConnectionAccepted ? '#42B574' : '#D1D5DB' }};">
                        </div>
                    </div>
                </label>
            </div>
        </div>

    </div>
</div>
