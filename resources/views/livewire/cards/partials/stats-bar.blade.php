<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Total cartes</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ $totalCards }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Actives</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ $activeCards }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Scans totaux</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ $totalScans }}</p>
            </div>
        </div>
    </div>
</div>
