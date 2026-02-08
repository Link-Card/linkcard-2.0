<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlanOverride;

class ExpirePlanOverrides extends Command
{
    protected $signature = 'plans:expire-overrides';
    protected $description = 'Expire plan overrides that have passed their expiration date';

    public function handle()
    {
        $expired = PlanOverride::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        $count = 0;
        foreach ($expired as $override) {
            try {
                $override->expire();
                $count++;
                $this->info("Expired override #{$override->id} for user #{$override->user_id}");
            } catch (\Exception $e) {
                $this->error("Failed to expire override #{$override->id}: {$e->getMessage()}");
            }
        }

        // Also expire impersonation requests older than 48h (pending) or expired (approved)
        \App\Models\ImpersonationRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(48))
            ->update(['status' => 'expired']);

        \App\Models\ImpersonationRequest::where('status', 'approved')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->update(['status' => 'expired']);

        $this->info("Done. {$count} plan override(s) expired.");

        return self::SUCCESS;
    }
}
