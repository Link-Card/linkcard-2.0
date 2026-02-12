<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Card;
use App\Models\CardOrder;
use App\Models\Profile;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderProcessing;
use App\Mail\OrderShipped;

class Dashboard extends Component
{
    use WithPagination;
    public string $activeTab = 'orders';
    public string $userSearch = '';
    public string $userSortField = 'created_at';
    public string $userSortDirection = 'desc';

    // Order editing
    public ?int $editingOrderId = null;
    public string $newStatus = '';
    public string $trackingNumber = '';

    // Delete modal (orders)
    public ?int $deletingOrderId = null;
    public string $deleteReason = '';
    public string $deleteNote = '';

    // Delete modal (users)
    public ?int $deletingUserId = null;
    public string $deleteUserReason = '';
    public string $deleteUserNote = '';
    public string $deleteUserPassword = '';
    public string $deleteUserError = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function sortUsers($field)
    {
        if ($this->userSortField === $field) {
            $this->userSortDirection = $this->userSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->userSortField = $field;
            $this->userSortDirection = $field === 'created_at' ? 'desc' : 'asc';
        }
        $this->resetPage();
    }

    public function updatedUserSearch()
    {
        $this->resetPage();
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

        // Commande livrée = terminée, pas de retour possible
        if ($order->status === 'delivered') {
            session()->flash('error', 'Cette commande est terminée (livrée). Aucune modification possible.');
            $this->cancelEdit();
            return;
        }

        $updates = ['status' => $this->newStatus];
        if ($this->trackingNumber) {
            $updates['tracking_number'] = $this->trackingNumber;
        }
        $order->update($updates);

        if ($this->newStatus === 'shipped') {
            Card::where('order_id', $order->id)->update(['shipped_at' => now()]);
        }

        // Send status emails
        $order->refresh();
        try {
            if ($this->newStatus === 'processing') {
                Mail::to($order->user->email)->send(new OrderProcessing($order));
            } elseif ($this->newStatus === 'shipped') {
                Mail::to($order->user->email)->send(new OrderShipped($order));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Order status email failed', [
                'order_id' => $orderId,
                'status' => $this->newStatus,
                'error' => $e->getMessage(),
            ]);
        }

        $this->cancelEdit();
        session()->flash('success', 'Commande ' . ($order->order_number ?? '#'.$orderId) . ' mise à jour.');
    }

    public function archiveOrder($orderId)
    {
        $order = CardOrder::findOrFail($orderId);
        $order->update(['status' => 'archived']);
        $this->cancelEdit();
        session()->flash('success', 'Commande ' . ($order->order_number ?? '#'.$orderId) . ' archivée.');
    }

    public function unarchiveOrder($orderId)
    {
        $order = CardOrder::findOrFail($orderId);
        $order->update(['status' => 'delivered']);
        session()->flash('success', 'Commande ' . ($order->order_number ?? '#'.$orderId) . ' restaurée.');
    }

    public function confirmDelete($orderId)
    {
        $this->deletingOrderId = $orderId;
        $this->editingOrderId = null;
        $this->deleteReason = '';
        $this->deleteNote = '';
    }

    public function cancelDelete()
    {
        $this->deletingOrderId = null;
        $this->deleteReason = '';
        $this->deleteNote = '';
    }

    public function deleteOrder()
    {
        if (!$this->deletingOrderId || !$this->deleteReason) return;

        $order = CardOrder::findOrFail($this->deletingOrderId);

        \Illuminate\Support\Facades\Log::info('Order deleted', [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'user_email' => $order->user->email ?? 'unknown',
            'amount_cents' => $order->amount_cents,
            'reason' => $this->deleteReason,
            'note' => $this->deleteNote,
            'deleted_by' => auth()->id(),
            'deleted_at' => now()->toISOString(),
        ]);

        Card::where('order_id', $order->id)->delete();
        $orderNumber = $order->order_number ?? '#'.$order->id;
        $order->delete();

        $this->cancelDelete();
        session()->flash('success', 'Commande ' . $orderNumber . ' supprimée.');
    }

    // === User deletion ===

    // Plan management
    public ?int $changingPlanUserId = null;
    public string $newPlan = '';
    public string $planDuration = '30'; // jours (0 = permanent)
    public string $planReason = '';
    public string $planNote = '';

    public function startChangePlan($userId, $currentPlan)
    {
        $this->changingPlanUserId = $userId;
        $this->newPlan = $currentPlan;
        $this->planDuration = '30';
        $this->planReason = '';
        $this->planNote = '';
    }

    public function cancelChangePlan()
    {
        $this->changingPlanUserId = null;
        $this->newPlan = '';
        $this->planDuration = '30';
        $this->planReason = '';
        $this->planNote = '';
    }

    public function changePlan()
    {
        if (!$this->changingPlanUserId || !$this->newPlan) return;

        $user = User::findOrFail($this->changingPlanUserId);
        $oldPlan = $user->plan;
        $isSelf = $user->id === auth()->id() && auth()->user()->role === 'super_admin';

        if ($oldPlan === $this->newPlan) {
            $this->cancelChangePlan();
            return;
        }

        // Cancel any existing active override
        \App\Models\PlanOverride::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create plan override record
        $expiresAt = $this->planDuration === '0' ? null : now()->addDays((int)$this->planDuration);

        \App\Models\PlanOverride::create([
            'user_id' => $user->id,
            'granted_plan' => $this->newPlan,
            'previous_plan' => $oldPlan,
            'granted_by' => auth()->id(),
            'reason' => $isSelf ? 'testing' : ($this->planReason ?: 'support'),
            'note' => $this->planNote,
            'starts_at' => now(),
            'expires_at' => $expiresAt,
            'status' => 'active',
        ]);

        // Update plan
        $user->update(['plan' => $this->newPlan]);

        // Apply limits on downgrade or unhide on upgrade
        $planOrder = ['free' => 0, 'pro' => 1, 'premium' => 2];
        if ($planOrder[$this->newPlan] < $planOrder[$oldPlan]) {
            \App\Services\PlanLimitsService::applyLimitsOnDowngrade($user);
        } elseif ($planOrder[$this->newPlan] > $planOrder[$oldPlan]) {
            \App\Services\PlanLimitsService::unhideOnUpgrade($user);
        }

        \Illuminate\Support\Facades\Log::info('Admin changed user plan', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'old_plan' => $oldPlan,
            'new_plan' => $this->newPlan,
            'duration_days' => $this->planDuration,
            'reason' => $this->planReason,
            'changed_by' => auth()->id(),
        ]);

        $newPlan = $this->newPlan;
        $userName = $user->name;
        $planLabels = ['free' => 'gratuit', 'pro' => 'pro', 'premium' => 'premium'];
        $oldLabel = $planLabels[$oldPlan] ?? $oldPlan;
        $newLabel = $planLabels[$newPlan] ?? $newPlan;
        $duration = $this->planDuration === '0' ? 'permanent' : $this->planDuration . 'j';
        $this->cancelChangePlan();
        session()->flash('success', "Plan de {$userName}: {$oldLabel} → {$newLabel} ({$duration})");
    }

    // Impersonation
    public string $impersonateReason = '';

    public function requestImpersonation($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->role === 'super_admin' || $user->role === 'admin') {
            session()->flash('error', 'Impossible de demander l\'accès à un compte administrateur.');
            return;
        }

        // Check if already pending
        $existing = \App\Models\ImpersonationRequest::where('admin_id', auth()->id())
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            session()->flash('error', 'Une demande est déjà en attente pour cet utilisateur.');
            return;
        }

        // Check if already approved and still valid
        $approved = \App\Models\ImpersonationRequest::where('admin_id', auth()->id())
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->where('expires_at', '>', now())
            ->first();

        if ($approved) {
            // Already approved → go directly
            return $this->doImpersonate($user);
        }

        // Create new request
        \App\Models\ImpersonationRequest::create([
            'admin_id' => auth()->id(),
            'user_id' => $userId,
            'reason' => $this->impersonateReason ?: 'Support technique',
            'status' => 'pending',
        ]);

        session()->flash('success', "Demande d'accès envoyée à {$user->name}. En attente d'approbation.");
    }

    public function cancelImpersonation($userId)
    {
        \App\Models\ImpersonationRequest::where('admin_id', auth()->id())
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);

        session()->flash('success', 'Demande d\'accès annulée.');
    }

    public function doImpersonate(User $user)
    {
        session(['impersonating_from' => auth()->id()]);
        auth()->login($user);
        return redirect()->route('dashboard');
    }

    public function confirmDeleteUser($userId)
    {
        $this->deletingUserId = $userId;
        $this->deleteUserReason = '';
        $this->deleteUserNote = '';
        $this->deleteUserPassword = '';
        $this->deleteUserError = '';
    }

    public function cancelDeleteUser()
    {
        $this->deletingUserId = null;
        $this->deleteUserReason = '';
        $this->deleteUserNote = '';
        $this->deleteUserPassword = '';
        $this->deleteUserError = '';
    }

    public function deleteUser()
    {
        $this->deleteUserError = '';

        if (!$this->deletingUserId) return;

        if (!$this->deleteUserReason) {
            $this->deleteUserError = 'Veuillez sélectionner une raison.';
            return;
        }

        if (!$this->deleteUserPassword) {
            $this->deleteUserError = 'Veuillez entrer votre mot de passe.';
            return;
        }

        // Verify admin password
        if (!\Illuminate\Support\Facades\Hash::check($this->deleteUserPassword, auth()->user()->password)) {
            $this->deleteUserError = 'Mot de passe incorrect.';
            $this->deleteUserPassword = '';
            return;
        }

        $user = User::findOrFail($this->deletingUserId);

        // Protect admin accounts
        if ($user->role === 'super_admin' || $user->role === 'admin') {
            $this->deleteUserError = 'Impossible de supprimer un compte administrateur.';
            return;
        }

        \Illuminate\Support\Facades\Log::info('User deleted by admin', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_plan' => $user->plan,
            'profiles_count' => $user->profiles()->count(),
            'cards_count' => $user->cards()->count(),
            'orders_count' => $user->cardOrders()->count(),
            'reason' => $this->deleteUserReason,
            'note' => $this->deleteUserNote,
            'deleted_by' => auth()->id(),
            'deleted_at' => now()->toISOString(),
        ]);

        // Delete related data
        foreach ($user->profiles as $profile) {
            // Delete profile images from storage
            if ($profile->photo_path) {
                \Illuminate\Support\Facades\Storage::delete($profile->photo_path);
            }
            foreach ($profile->contentBands as $band) {
                if ($band->type === 'image' && isset($band->data['images'])) {
                    foreach ($band->data['images'] as $image) {
                        if (isset($image['path'])) {
                            \Illuminate\Support\Facades\Storage::delete($image['path']);
                        }
                    }
                }
            }
            $profile->contentBands()->delete();
            $profile->delete();
        }

        // Cancel Stripe subscription if active
        try {
            if ($user->subscribed('default')) {
                $user->subscription('default')->cancelNow();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to cancel Stripe subscription on user delete', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        // Delete order logos from storage
        foreach ($user->cardOrders as $order) {
            if ($order->logo_path) {
                \Illuminate\Support\Facades\Storage::delete($order->logo_path);
            }
        }

        $user->cards()->delete();
        $user->cardOrders()->delete();

        $userName = $user->name;
        $user->delete();

        $this->cancelDeleteUser();
        session()->flash('success', 'Utilisateur "' . $userName . '" supprimé.');
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
            'freeUsers' => User::where('plan', 'free')->count(),
        ];

        // Admin stats data
        $adminStats = [];
        if ($this->activeTab === 'statistics') {
            $adminStats = $this->getAdminStats();
        }

        $orders = CardOrder::with('user')
            ->whereNotIn('status', ['pending', 'archived'])
            ->orderByDesc('created_at')
            ->get();

        $archivedOrders = CardOrder::with('user')
            ->where('status', 'archived')
            ->orderByDesc('created_at')
            ->get();

        $usersQuery = User::with('profiles')
            ->withCount(['profiles', 'cards', 'cardOrders'])
            ->withSum('profiles as total_views', 'view_count');

        // Search
        if ($this->userSearch) {
            $search = $this->userSearch;
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profiles', function ($pq) use ($search) {
                      $pq->where('username', 'like', "%{$search}%");
                  });
            });
        }

        // Sort by column
        $sortField = $this->userSortField;
        $sortDir = $this->userSortDirection;

        if (in_array($sortField, ['id', 'name', 'email', 'plan', 'role', 'created_at'])) {
            $usersQuery->orderBy($sortField, $sortDir);
        } elseif ($sortField === 'profiles_count') {
            $usersQuery->orderBy('profiles_count', $sortDir);
        } elseif ($sortField === 'cards_count') {
            $usersQuery->orderBy('cards_count', $sortDir);
        } elseif ($sortField === 'card_orders_count') {
            $usersQuery->orderBy('card_orders_count', $sortDir);
        } elseif ($sortField === 'total_views') {
            $usersQuery->orderBy('total_views', $sortDir);
        } else {
            $usersQuery->orderByDesc('created_at');
        }

        $users = $usersQuery->paginate(50);

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'adminStats' => $adminStats,
            'orders' => $orders,
            'archivedOrders' => $archivedOrders,
            'users' => $users,
        ])->layout('layouts.dashboard');
    }

    private function getAdminStats(): array
    {
        // Inscriptions par jour (30 derniers jours)
        $signupsByDay = User::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Remplir les jours manquants
        $filledSignups = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $filledSignups[$date] = $signupsByDay[$date] ?? 0;
        }

        // Inscriptions par plan (30 derniers jours)
        $signupsByPlan = User::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('plan, COUNT(*) as count')
            ->groupBy('plan')
            ->pluck('count', 'plan')
            ->toArray();

        // Inscriptions cette semaine vs semaine dernière
        $thisWeek = User::where('created_at', '>=', now()->startOfWeek())->count();
        $lastWeek = User::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->startOfWeek()])->count();

        // Inscriptions ce mois vs mois dernier
        $thisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $lastMonth = User::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->startOfMonth()])->count();

        // Vues totales profils (30 derniers jours)
        $totalProfileViews = \App\Models\ProfileView::where('viewed_at', '>=', now()->subDays(30))->count();

        // Vues par jour (30 derniers jours)
        $viewsByDay = \App\Models\ProfileView::where('viewed_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $filledViews = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $filledViews[$date] = $viewsByDay[$date] ?? 0;
        }

        // Top profils vus (30 derniers jours)
        $topProfiles = \App\Models\ProfileView::where('viewed_at', '>=', now()->subDays(30))
            ->join('profiles', 'profile_views.profile_id', '=', 'profiles.id')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->selectRaw('profiles.username, users.name, COUNT(*) as views')
            ->groupBy('profiles.username', 'users.name')
            ->orderByDesc('views')
            ->limit(5)
            ->get()
            ->toArray();

        // Clics totaux (30 derniers jours)
        $totalClicks = \App\Models\LinkClick::where('clicked_at', '>=', now()->subDays(30))->count();

        // Revenus cartes NFC par mois (6 derniers mois)
        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $label = $start->translatedFormat('M Y');
            $revenue = CardOrder::whereNotIn('status', ['pending'])
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount_cents');
            $revenueByMonth[$label] = $revenue;
        }

        // Conversion: users qui ont upgrade
        $upgradedUsers = User::whereIn('plan', ['pro', 'premium'])->count();
        $conversionRate = User::count() > 0 ? round(($upgradedUsers / User::count()) * 100, 1) : 0;

        return [
            'signupsByDay' => $filledSignups,
            'signupsByPlan' => $signupsByPlan,
            'thisWeek' => $thisWeek,
            'lastWeek' => $lastWeek,
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
            'totalProfileViews' => $totalProfileViews,
            'viewsByDay' => $filledViews,
            'topProfiles' => $topProfiles,
            'totalClicks' => $totalClicks,
            'revenueByMonth' => $revenueByMonth,
            'conversionRate' => $conversionRate,
            'upgradedUsers' => $upgradedUsers,
        ];
    }
}
