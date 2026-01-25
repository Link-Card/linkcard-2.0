<div class="p-8 max-w-md mx-auto mt-10 bg-white rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-primary-800 mb-6 text-center">
        🚀 Test Livewire + Tailwind
    </h2>
    
    <div class="text-center mb-6">
        <span class="text-6xl font-bold text-primary-700">{{ $count }}</span>
    </div>
    
    <div class="flex gap-4 justify-center">
        <button 
            wire:click="decrement" 
            class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">
            ➖ Diminuer
        </button>
        
        <button 
            wire:click="increment" 
            class="px-6 py-3 bg-primary-800 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
            ➕ Augmenter
        </button>
    </div>
    
    <p class="text-center mt-6 text-gray-600 text-sm">
        ✅ Laravel 11 + Livewire 4 + TailwindCSS
    </p>
</div>
