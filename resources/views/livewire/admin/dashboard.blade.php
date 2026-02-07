<div class="p-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold" style="color: #2C2A27;">Administration</h1>
        <p class="text-sm mt-1" style="color: #4B5563;">Gestion des commandes, utilisateurs et statistiques.</p>
    </div>

    <!-- Stats globales -->
    @include('livewire.admin.partials.stats')

    <!-- Tabs -->
    <div class="flex space-x-1 mb-6 p-1 rounded-lg" style="background-color: #F3F4F6;">
        <button wire:click="setTab('orders')"
                class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-all"
                style="{{ $activeTab === 'orders' ? 'background-color: #FFFFFF; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #4B5563;' }}">
            Commandes
            @if($stats['pendingOrders'] > 0)
                <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full text-white" style="background-color: #F59E0B;">{{ $stats['pendingOrders'] }}</span>
            @endif
        </button>
        <button wire:click="setTab('archived')"
                class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-all"
                style="{{ $activeTab === 'archived' ? 'background-color: #FFFFFF; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #4B5563;' }}">
            Archives ({{ $archivedOrders->count() }})
        </button>
        <button wire:click="setTab('users')"
                class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-all"
                style="{{ $activeTab === 'users' ? 'background-color: #FFFFFF; color: #2C2A27; box-shadow: 0 1px 3px rgba(0,0,0,0.1);' : 'color: #4B5563;' }}">
            Utilisateurs ({{ $stats['totalUsers'] }})
        </button>
    </div>

    <!-- Tab content -->
    @if($activeTab === 'orders')
        @include('livewire.admin.partials.orders-list')
    @elseif($activeTab === 'archived')
        @include('livewire.admin.partials.archives-list')
    @elseif($activeTab === 'users')
        @include('livewire.admin.partials.users-list')
    @endif
</div>
