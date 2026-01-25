<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations de base
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->text('bio')->nullable();
            
            // Photo
            $table->string('photo_path')->nullable();
            
            // Apparence
            $table->string('template_id')->default('default');
            $table->string('primary_color')->default('#2D7A4F');
            $table->string('secondary_color')->default('#00FF85');
            $table->string('background_type')->default('gradient'); // gradient, solid, image
            $table->string('background_value')->nullable();
            
            // Visibilité & Stats
            $table->boolean('is_public')->default(true);
            $table->integer('view_count')->default(0);
            $table->integer('click_count')->default(0);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('username');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
