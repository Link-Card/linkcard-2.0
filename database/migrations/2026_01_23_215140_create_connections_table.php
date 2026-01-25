<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            
            // Les deux utilisateurs connectés
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('connected_user_id')->constrained('users')->onDelete('cascade');
            
            // Type de connexion
            $table->enum('type', [
                'mutual',      // Connexion mutuelle (les deux ont accepté)
                'pending',     // En attente (invitation envoyée)
                'blocked'      // Bloqué
            ])->default('pending');
            
            // Métadonnées de connexion
            $table->string('source')->nullable(); // Comment ils se sont connectés (nfc, qr, search, etc.)
            $table->text('note')->nullable();     // Note personnelle sur la connexion
            $table->boolean('is_favorite')->default(false);
            
            // Qui a initié
            $table->foreignId('initiated_by')->constrained('users')->onDelete('cascade');
            
            // Dates importantes
            $table->timestamp('connected_at')->nullable(); // Quand connexion acceptée
            $table->timestamp('last_interaction_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('user_id');
            $table->index('connected_user_id');
            $table->index(['user_id', 'connected_user_id']);
            $table->index('type');
            
            // Éviter les doublons
            $table->unique(['user_id', 'connected_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
