<div class="space-y-4">
    @foreach($cards as $card)
        @include('livewire.cards.partials.card-item', ['card' => $card])
    @endforeach
</div>
