<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Vues détaillées du profil
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('ip_hash', 64)->nullable(); // Hash SHA256 pour dédupliquer sans stocker IP
            $table->string('source', 30)->nullable();   // direct, nfc, qr, share, search
            $table->string('referer_domain', 100)->nullable();
            $table->string('device_type', 20)->nullable(); // mobile, desktop, tablet
            $table->timestamp('viewed_at');

            $table->index(['profile_id', 'viewed_at']);
            $table->index(['profile_id', 'ip_hash', 'viewed_at']);
        });

        // Clics sur les liens (PREMIUM)
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('content_band_id')->constrained()->onDelete('cascade');
            $table->string('platform', 30)->nullable();  // linkedin, instagram, etc.
            $table->string('url', 500)->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->timestamp('clicked_at');

            $table->index(['profile_id', 'clicked_at']);
            $table->index(['content_band_id', 'clicked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
        Schema::dropIfExists('profile_views');
    }
};
