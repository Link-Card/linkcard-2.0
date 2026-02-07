<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Referral
            $table->string('referral_code', 8)->unique()->nullable()->after('role');
            $table->foreignId('referred_by')->nullable()->after('referral_code')->constrained('users')->nullOnDelete();
            $table->unsignedSmallInteger('premium_bonus_months')->default(0)->after('referred_by');
            $table->unsignedSmallInteger('premium_bonus_used')->default(0)->after('premium_bonus_months');

            // Notification preferences
            $table->boolean('notify_connection_request')->default(true)->after('premium_bonus_used');
            $table->boolean('notify_connection_accepted')->default(true)->after('notify_connection_request');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn([
                'referral_code',
                'referred_by',
                'premium_bonus_months',
                'premium_bonus_used',
                'notify_connection_request',
                'notify_connection_accepted',
            ]);
        });
    }
};
