<div class="flex items-center justify-between">
    @foreach([1 => 'Cartes', 2 => 'Livraison', 3 => 'Résumé'] as $num => $label)
        <div class="flex items-center {{ $num < 3 ? 'flex-1' : '' }}">
            <div class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-semibold transition-colors
                {{ $step >= $num ? 'text-white' : '' }}"
                style="background-color: {{ $step >= $num ? '#42B574' : '#E5E7EB' }}; color: {{ $step >= $num ? '#FFFFFF' : '#9CA3AF' }};">
                @if($step > $num)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                @else
                    {{ $num }}
                @endif
            </div>
            <span class="ml-2 text-sm font-medium {{ $step >= $num ? '' : '' }}" style="color: {{ $step >= $num ? '#2C2A27' : '#9CA3AF' }};">
                {{ $label }}
            </span>
            @if($num < 3)
                <div class="flex-1 h-px mx-4" style="background-color: {{ $step > $num ? '#42B574' : '#E5E7EB' }};"></div>
            @endif
        </div>
    @endforeach
</div>
