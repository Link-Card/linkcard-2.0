<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old table if exists
        Schema::dropIfExists('nfc_cards');

        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_code', 8)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('profile_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->foreignId('order_id')->nullable();
            $table->timestamp('programmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->integer('scan_count')->default(0);
            $table->timestamp('last_scanned_at')->nullable();
            $table->timestamps();

            $table->index('card_code');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
