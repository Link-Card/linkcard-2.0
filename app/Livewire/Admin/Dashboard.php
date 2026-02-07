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

    // Phase 4B: action fields
    public ?int $editingOrderId = null;
    public string $newStatus = '';
    public string $trackingNumber = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function startEdit($orderId)
    {
        $this->editingOrderId = $orderId;
        $order = CardOrder::findOrFail($orderId);
        $this->newStatus = $order->status;
        $this->trackingNumber = $order->tracking_number ?? '';
    }

    public function cancelEdit()
    {
        $this->editingOrderId = null;
        $this->newStatus = '';
        $this->trackingNumber = '';
    }

    public function updateOrderStatus($orderId)
    {
        $order = CardOrder::findOrFail($orderId);

        $updates = ['status' => $this->newStatus];

        if ($this->trackingNumber) {
            $updates['tracking_number'] = $this->trackingNumber;
        }

        $order->update($updates);

        // If shipped: record shipped_at on cards
        if ($this->newStatus === 'shipped') {
            Card::where('order_id', $order->id)->update(['shipped_at' => now()]);
        }

        $this->cancelEdit();
        session()->flash('success', 'Commande #' . $orderId . ' mise à jour.');
    }

    public function deleteOrder($orderId)
    {
        $order = CardOrder::findOrFail($orderId);

        if ($order->status !== 'pending') {
            session()->flash('error', 'Seules les commandes en attente peuvent être supprimées.');
            return;
        }

        $order->delete();
        session()->flash('success', 'Commande #' . $orderId . ' supprimée.');
    }

    public function render()
    {
        // Monthly recurring revenue
        $proMonthly = User::where('plan', 'pro')->count() * 500;
        $premiumMonthly = User::where('plan', 'premium')->count() * 800;

        $stats = [
            'totalUsers' => User::count(),
            'totalProfiles' => Profile::count(),
            'totalOrders' => CardOrder::count(),
            'totalCards' => Card::count(),
            'totalRevenue' => CardOrder::where('status', '!=', 'pending')->sum('amount_cents'),
            'monthlyRecurring' => $proMonthly + $premiumMonthly,
            'pendingOrders' => CardOrder::where('status', 'paid')->count(),
            'activeCards' => Card::where('is_active', true)->count(),
            'totalScans' => Card::sum('scan_count'),
            'proUsers' => User::where('plan', 'pro')->count(),
            'premiumUsers' => User::where('plan', 'premium')->count(),
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
