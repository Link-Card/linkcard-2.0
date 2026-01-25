<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            
            // Informations de base
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('preview_image')->nullable();
            
            // Catégorie
            $table->enum('category', [
                'business',      // Professionnel
                'creative',      // Créatif
                'minimal',       // Minimaliste
                'modern',        // Moderne
                'elegant',       // Élégant
                'tech',          // Technologie
                'entertainment', // Divertissement
                'education'      // Éducation
            ])->default('business');
            
            // Configuration du template (JSON)
            $table->json('config');
            // Exemple: {
            //   "layout": "vertical",
            //   "button_style": "rounded",
            //   "animation": "fade",
            //   "default_colors": {
            //     "primary": "#2D7A4F",
            //     "secondary": "#00FF85"
            //   }
            // }
            
            // Type et disponibilité
            $table->enum('type', ['default', 'premium', 'custom'])->default('default');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            
            // Plans requis pour utiliser ce template
            $table->json('required_plans')->nullable(); // ["free", "basic", "pro"] ou null = tous
            
            // Statistiques
            $table->integer('usage_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            
            // Auteur (si template custom créé par équipe)
            $table->string('author')->nullable();
            $table->string('author_url')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('slug');
            $table->index('category');
            $table->index('type');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
