<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('granted_plan', 20);           // pro, premium
            $table->string('previous_plan', 20);           // plan avant l'override
            $table->foreignId('granted_by')->constrained('users'); // admin qui a attribué
            $table->string('reason', 50);                  // beta, support, promo, gift, testing
            $table->text('note')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('expires_at')->nullable();    // null = permanent
            $table->string('status', 20)->default('active'); // active, expired, cancelled
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['expires_at', 'status']);
        });

        // Impersonation requests
        Schema::create('impersonation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('reason', 255)->nullable();
            $table->string('status', 20)->default('pending'); // pending, approved, denied, expired
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();       // 24h after approval
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impersonation_requests');
        Schema::dropIfExists('plan_overrides');
    }
};
