<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Card;
use App\Models\CardOrder;
use App\Models\Profile;

class Dashboard extends Component
{
    public string $activeTab = 'orders';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalProfiles' => Profile::count(),
            'totalOrders' => CardOrder::count(),
            'totalCards' => Card::count(),
            'totalRevenue' => CardOrder::where('status', '!=', 'pending')->sum('amount_cents'),
            'pendingOrders' => CardOrder::where('status', 'paid')->count(),
            'activeCards' => Card::where('is_active', true)->count(),
            'totalScans' => Card::sum('scan_count'),
        ];

        $orders = CardOrder::with('user')
            ->orderByDesc('created_at')
            ->get();

        $users = User::withCount(['profiles', 'cards', 'cardOrders'])
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'orders' => $orders,
            'users' => $users,
        ])->layout('layouts.dashboard');
    }
}
