<div class="p-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold" style="color: #2C2A27;">Mes Cartes NFC</h1>
            <p class="text-sm mt-1" style="color: #4B5563;">Gérez vos cartes NFC et leurs profils liés.</p>
        </div>
        <a href="{{ route('cards.order') }}" class="px-4 py-2 rounded-lg text-white text-sm font-medium transition-colors" style="background-color: #42B574;" onmouseover="this.style.backgroundColor='#3DA367'" onmouseout="this.style.backgroundColor='#42B574'">
            + Commander une carte
        </a>
    </div>

    @if(session()->has('success'))
        <div class="mb-6 p-4 rounded-lg" style="background-color: #F0F9F4; border: 1px solid #42B574; color: #2D7A4F;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats -->
    @include('livewire.cards.partials.stats-bar')

    <!-- Cards list or empty state -->
    @if($totalCards > 0)
        @include('livewire.cards.partials.card-list')
    @else
        @include('livewire.cards.partials.empty-state')
    @endif
</div>
