<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold" style="color: #2C2A27; font-family: 'Manrope', sans-serif;">
                    Mes Cartes NFC
                </h1>
                <p class="mt-1 text-sm" style="color: #4B5563;">
                    Gérez vos cartes NFC et leurs profils liés.
                </p>
            </div>
            <a href="{{ route('cards.order') }}"
               class="px-5 py-2.5 rounded-lg text-white text-sm font-medium transition-colors"
               style="background-color: #42B574;"
               onmouseover="this.style.backgroundColor='#3DA367'"
               onmouseout="this.style.backgroundColor='#42B574'">
                + Commander une carte
            </a>
        </div>

        {{-- Stats --}}
        @include('livewire.cards.partials.stats-bar', ['stats' => $stats])

        {{-- Liste ou empty state --}}
        @if($cards->isEmpty())
            @include('livewire.cards.partials.empty-state')
        @else
            @include('livewire.cards.partials.card-list', ['cards' => $cards, 'profiles' => $profiles])
        @endif

    </div>
</div>
