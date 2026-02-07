{{-- Liste des cartes --}}
<div class="space-y-4">
    @foreach($cards as $card)
        @include('livewire.cards.partials.card-item', ['card' => $card, 'profiles' => $profiles])
    @endforeach
</div>
