<?php

namespace App\Console\Commands;

use App\Models\CardOrder;
use Illuminate\Console\Command;

class ArchiveDeliveredOrders extends Command
{
    protected $signature = 'orders:archive-delivered';
    protected $description = 'Archive les commandes livrées depuis plus de 30 jours';

    public function handle()
    {
        $count = CardOrder::where('status', 'delivered')
            ->where('updated_at', '<=', now()->subDays(30))
            ->update(['status' => 'archived']);

        $this->info("Archivé {$count} commande(s).");
        return Command::SUCCESS;
    }
}
