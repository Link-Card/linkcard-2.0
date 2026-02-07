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

    // Order editing
    public ?int $editingOrderId = null;
    public string $newStatus = '';
    public string $trackingNumber = '';

    // Delete modal
    public ?int $deletingOrderId = null;
    public string $deleteReason = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function startEdit($orderId)
    {
        $this->editingOrderId = $orderId;
        $this->deletingOrderId = null;
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

        if ($this->newStatus === 'shipped') {
            Card::where('order_id', $order->id)->update(['shipped_at' => now()]);
        }

        $this->cancelEdit();
        session()->flash('success', 'Commande #' . $orderId . ' mise à jour.');
    }

    public function archiveOrder($orderId)
    {
        $order = CardOrder::findOrFail($orderId);
        $order->update(['status' => 'archived']);
        session()->flash('success', 'Commande #' . $orderId . ' archivée. Le revenu est conservé.');
    }

    public function confirmDelete($orderId)
    {
        $this->deletingOrderId = $orderId;
        $this->editingOrderId = null;
        $this->deleteReason = '';
    }

    public function cancelDelete()
    {
        $this->deletingOrderId = null;
        $this->deleteReason = '';
    }

    public function deleteOrder()
    {
        if (!$this->deletingOrderId) return;

        $order = CardOrder::findOrFail($this->deletingOrderId);

        // Log the deletion reason
        \Illuminate\Support\Facades\Log::info('Order deleted', [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount_cents' => $order->amount_cents,
            'reason' => $this->deleteReason,
            'deleted_by' => auth()->id(),
        ]);

        // Delete associated cards
        Card::where('order_id', $order->id)->delete();

        $orderId = $order->id;
        $order->delete();

        $this->cancelDelete();
        session()->flash('success', 'Commande #' . $orderId . ' supprimée. Revenus ajustés.');
    }

    public function render()
    {
        $proMonthly = User::where('plan', 'pro')->count() * 500;
        $premiumMonthly = User::where('plan', 'premium')->count() * 800;

        $stats = [
            'totalUsers' => User::count(),
            'totalProfiles' => Profile::count(),
            'totalOrders' => CardOrder::whereNotIn('status', ['pending', 'archived'])->count(),
            'totalCards' => Card::count(),
            'totalRevenue' => CardOrder::whereNotIn('status', ['pending'])->sum('amount_cents'),
            'monthlyRecurring' => $proMonthly + $premiumMonthly,
            'pendingOrders' => CardOrder::where('status', 'paid')->count(),
            'activeCards' => Card::where('is_active', true)->count(),
            'totalScans' => Card::sum('scan_count'),
            'proUsers' => User::where('plan', 'pro')->count(),
            'premiumUsers' => User::where('plan', 'premium')->count(),
        ];

        $orders = CardOrder::with('user')
            ->whereNotIn('status', ['pending', 'archived'])
            ->orderByDesc('created_at')
            ->get();

        $archivedOrders = CardOrder::with('user')
            ->where('status', 'archived')
            ->orderByDesc('created_at')
            ->get();

        $users = User::withCount(['profiles', 'cards', 'cardOrders'])
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'orders' => $orders,
            'archivedOrders' => $archivedOrders,
            'users' => $users,
        ])->layout('layouts.dashboard');
    }
}
