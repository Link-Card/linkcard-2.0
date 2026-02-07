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
            <h1 class="text-2xl font-semibold" style="color: #2C2A27;">Commander une carte NFC</h1>
        </div>

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
    </div>
</div>
