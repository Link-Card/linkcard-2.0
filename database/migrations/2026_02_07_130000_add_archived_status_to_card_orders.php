<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE card_orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'delivered', 'archived') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE card_orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'delivered') DEFAULT 'pending'");
    }
};
