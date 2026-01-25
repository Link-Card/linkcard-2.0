<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            
            // Type de module
            $table->enum('type', [
                'social',      // Liens réseaux sociaux
                'link',        // Lien personnalisé
                'text',        // Bloc de texte
                'video',       // Vidéo YouTube/Vimeo
                'image',       // Image
                'gallery',     // Galerie d'images
                'contact',     // Formulaire contact
                'document',    // Document téléchargeable
                'calendar',    // Calendly/Cal.com
                'spotify',     // Playlist Spotify
                'payment'      // Lien paiement
            ]);
            
            // Contenu (JSON pour flexibilité)
            $table->json('data');
            // Exemple data pour 'social': {"platform": "linkedin", "url": "...", "username": "..."}
            // Exemple data pour 'link': {"title": "Mon site", "url": "...", "icon": "..."}
            
            // Apparence
            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
            
            // Organisation
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            
            // Analytics
            $table->integer('click_count')->default(0);
            $table->timestamp('last_clicked_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('profile_id');
            $table->index(['profile_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_modules');
    }
};
