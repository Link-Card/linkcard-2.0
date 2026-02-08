<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ajouter username_changed_at aux profils
        Schema::table('profiles', function (Blueprint $table) {
            $table->timestamp('username_changed_at')->nullable()->after('username');
        });

        // Table de redirections pour anciens usernames (90 jours)
        Schema::create('username_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('old_username', 30)->unique();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('old_username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('username_redirects');
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('username_changed_at');
        });
    }
};
