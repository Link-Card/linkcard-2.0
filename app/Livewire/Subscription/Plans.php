<?php

namespace App\Livewire\Subscription;

use Livewire\Component;

class Plans extends Component
{
    public string $billingCycle = 'monthly';
    public bool $showSuccessMessage = false;
    public bool $showDowngradeWarning = false;
    public string $downgradeTo = '';

    public function mount()
    {
        // Détecter si on revient du portail Stripe
        if (request()->has('portal_return')) {
            $this->showSuccessMessage = true;
        }
    }

    public function subscribe(string $plan)
    {
        if (session('impersonating_from')) {
            session()->flash('error', 'Les transactions ne sont pas disponibles en mode assistance.');
            return;
        }

        $user = auth()->user();

        $priceId = $this->billingCycle === 'monthly'
            ? config("services.stripe.price_{$plan}_monthly")
            : config("services.stripe.price_{$plan}_yearly");

        if (!$priceId) {
            session()->flash('error', 'Prix non configuré');
            return;
        }

        // Si déjà abonné, rediriger vers le portail pour changer de plan
        if ($user->subscribed('default')) {
            return $this->redirectToPortal();
        }

        // Nouveau client, créer checkout
        $checkout = $user->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscription.plans'),
            ]);

        return $this->redirect($checkout->url, navigate: false);
    }

    public function redirectToPortal()
    {
        if (session('impersonating_from')) {
            session()->flash('error', 'Les transactions ne sont pas disponibles en mode assistance.');
            return;
        }

        // Ajouter ?portal_return=1 pour détecter le retour
        $returnUrl = route('subscription.plans') . '?portal_return=1';
        $url = auth()->user()->billingPortalUrl($returnUrl);
        return $this->redirect($url, navigate: false);
    }

    public function showDowngradeConfirm(string $plan)
    {
        $this->downgradeTo = $plan;
        $this->showDowngradeWarning = true;
    }

    public function confirmDowngrade()
    {
        $this->showDowngradeWarning = false;
        return $this->redirectToPortal();
    }

    public function cancelDowngrade()
    {
        $this->showDowngradeWarning = false;
        $this->downgradeTo = '';
    }

    /**
     * Calcule ce que l'utilisateur va perdre en passant à un plan inférieur
     */
    private function getDowngradeLosses(string $currentPlan, string $targetPlan): array
    {
        $user = auth()->user();
        $losses = [];

        $currentLimits = \App\Services\PlanLimitsService::getLimits($currentPlan);
        $targetLimits = \App\Services\PlanLimitsService::getLimits($targetPlan);

        // URL custom
        if ($targetPlan === 'free') {
            $hasCustomUrl = $user->profiles()->whereNotNull('username_changed_at')->exists();
            if ($hasCustomUrl) {
                $losses[] = 'Votre lien personnalisé (remplacé par un code aléatoire)';
            }
        }

        // QR Code
        if (in_array($currentPlan, ['pro', 'premium']) && $targetPlan === 'free') {
            $losses[] = 'QR Code popup sur votre profil';
        }

        // Liens sociaux
        if ($targetLimits['social_links'] < $currentLimits['social_links']) {
            foreach ($user->profiles as $profile) {
                $usage = \App\Services\PlanLimitsService::getCurrentUsage($profile);
                $excess = $usage['social_links'] - $targetLimits['social_links'];
                if ($excess > 0) {
                    $losses[] = $excess . ' lien(s) sociaux seront masqués (max ' . $targetLimits['social_links'] . ' avec ce forfait)';
                    break;
                }
            }
        }

        // Images
        if ($targetLimits['images'] < $currentLimits['images']) {
            foreach ($user->profiles as $profile) {
                $usage = \App\Services\PlanLimitsService::getCurrentUsage($profile);
                $excess = $usage['images'] - $targetLimits['images'];
                if ($excess > 0) {
                    $losses[] = $excess . ' image(s) seront masquées (max ' . $targetLimits['images'] . ' avec ce forfait)';
                    break;
                }
            }
        }

        // Texte
        if ($targetLimits['text_blocks'] < $currentLimits['text_blocks']) {
            foreach ($user->profiles as $profile) {
                $usage = \App\Services\PlanLimitsService::getCurrentUsage($profile);
                $excess = $usage['text_blocks'] - $targetLimits['text_blocks'];
                if ($excess > 0) {
                    $losses[] = $excess . ' section(s) texte seront masquées (max ' . $targetLimits['text_blocks'] . ' avec ce forfait)';
                    break;
                }
            }
        }

        if (empty($losses)) {
            $losses[] = 'Accès aux fonctionnalités ' . ($currentPlan === 'premium' ? 'Premium' : 'Pro');
        }

        return $losses;
    }

    public function render()
    {
        $user = auth()->user();
        
        $subscription = $user->subscription('default');
        $isSubscribed = $user->subscribed('default');
        $onGracePeriod = $subscription?->onGracePeriod() ?? false;
        $endsAt = $subscription?->ends_at;
        
        $plans = [
            'premium' => [
                'name' => 'Premium',
                'price_monthly' => 8,
                'price_yearly' => 80,
                'features' => [
                    '1 profil (+8$/mois par extra)',
                    'Username personnalisé obligatoire',
                    '10 liens sociaux',
                    '10 images avec liens',
                    '5 sections texte',
                    'QR Code popup',
                ],
            ],
            'pro' => [
                'name' => 'Pro',
                'price_monthly' => 5,
                'price_yearly' => 50,
                'features' => [
                    '1 profil (+5$/mois par extra)',
                    'Username personnalisé',
                    '5 liens sociaux',
                    '5 images avec liens',
                    '2 sections texte',
                    'QR Code popup',
                ],
            ],
            'free' => [
                'name' => 'Gratuit',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'features' => [
                    '1 profil',
                    'Code 8 caractères aléatoire',
                    '3 liens sociaux',
                    '2 images (sans liens)',
                    '1 section texte',
                ],
            ],
        ];

        // Calculate downgrade losses if showing warning
        $downgradeLosses = [];
        if ($this->showDowngradeWarning && $this->downgradeTo) {
            $downgradeLosses = $this->getDowngradeLosses($user->plan ?? 'free', $this->downgradeTo);
        }

        // Detect admin-granted plan (has plan but no Stripe subscription)
        $activeOverride = \App\Models\PlanOverride::where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function ($q) { $q->whereNull('expires_at')->orWhere('expires_at', '>', now()); })
            ->first();
        $isAdminGranted = $activeOverride !== null || (!$isSubscribed && $user->plan !== 'free');
        $isSuperAdmin = $user->role === 'super_admin';

        return view('livewire.subscription.plans', [
            'plans' => $plans,
            'currentPlan' => $user->plan ?? 'free',
            'isSubscribed' => $isSubscribed,
            'isAdminGranted' => $isAdminGranted,
            'isSuperAdmin' => $isSuperAdmin,
            'activeOverride' => $activeOverride,
            'onGracePeriod' => $onGracePeriod,
            'endsAt' => $endsAt,
            'downgradeLosses' => $downgradeLosses,
        ])->layout('layouts.dashboard');
    }
}
