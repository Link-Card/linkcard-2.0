<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add terms acceptance + suspension to users
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('accepted_terms_at')->nullable()->after('remember_token');
            $table->boolean('is_suspended')->default(false)->after('accepted_terms_at');
            $table->string('suspension_reason', 255)->nullable()->after('is_suspended');
            $table->timestamp('suspended_at')->nullable()->after('suspension_reason');
            $table->unsignedBigInteger('suspended_by')->nullable()->after('suspended_at');
        });

        // Profile reports
        Schema::create('profile_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('reporter_id')->nullable(); // null = anonymous
            $table->string('reason'); // explicit_content, illegal_content, harassment, spam, impersonation, other
            $table->text('details')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, actioned, dismissed
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_reports');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['accepted_terms_at', 'is_suspended', 'suspension_reason', 'suspended_at', 'suspended_by']);
        });
    }
};
