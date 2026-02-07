<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('cards.index') }}" class="inline-flex items-center text-sm mb-4 transition-colors" style="color: #4B5563;" onmouseover="this.style.color='#42B574'" onmouseout="this.style.color='#4B5563'">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour aux cartes
            </a>
            <h1 class="text-2xl font-semibold" style="color: #2C2A27;">Commander des cartes NFC</h1>
        </div>

        @if($noProfiles)
            <!-- No profile state -->
            <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: #FEF3C7;">
                    <svg class="w-8 h-8" style="color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold mb-2" style="color: #2C2A27;">Créez d'abord un profil</h2>
                <p class="text-sm mb-6" style="color: #4B5563;">
                    Vous devez avoir au moins un profil avant de commander des cartes NFC. Les cartes seront liées à votre profil.
                </p>
                <a href="{{ route('profile.create') }}" class="inline-block px-6 py-3 rounded-lg text-white font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
                    Créer mon profil
                </a>
            </div>
        @else
            <!-- Messages -->
            @if(session()->has('error'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #FEF2F2; border: 1px solid #EF4444; color: #991B1B;">
                    {{ session('error') }}
                </div>
            @endif

            @if(request()->has('cancelled'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #FEF3C7; border: 1px solid #F59E0B; color: #92400E;">
                    Paiement annulé. Vous pouvez réessayer.
                </div>
            @endif

            <!-- Step indicator -->
            @include('livewire.cards.partials.order-steps')

            <!-- Step content -->
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                @if($step === 1)
                    @include('livewire.cards.partials.order-design')
                @elseif($step === 2)
                    @include('livewire.cards.partials.order-address')
                @elseif($step === 3)
                    @include('livewire.cards.partials.order-summary')
                @endif
            </div>
        @endif
    </div>
</div>
