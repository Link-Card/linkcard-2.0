<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Users -->
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Utilisateurs</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ $stats['totalUsers'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #EFF6FF;">
                <svg class="w-5 h-5" style="color: #4A7FBF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Commandes</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ $stats['totalOrders'] }}</p>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0F9F4;">
                <svg class="w-5 h-5" style="color: #42B574;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">Revenus</p>
                <p class="text-xl font-semibold" style="color: #2C2A27;">{{ number_format($stats['totalRevenue'] / 100, 2) }}$</p>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $stats['pendingOrders'] > 0 ? '#FEF3C7' : '#F0F9F4' }};">
                <svg class="w-5 h-5" style="color: {{ $stats['pendingOrders'] > 0 ? '#F59E0B' : '#42B574' }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs" style="color: #9CA3AF;">En attente</p>
                <p class="text-xl font-semibold" style="color: {{ $stats['pendingOrders'] > 0 ? '#F59E0B' : '#2C2A27' }};">{{ $stats['pendingOrders'] }}</p>
            </div>
        </div>
    </div>
</div>
