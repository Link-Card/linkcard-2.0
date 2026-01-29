<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('email', 100)->nullable()->after('bio');
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('website', 255)->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'website']);
        });
    }
};
