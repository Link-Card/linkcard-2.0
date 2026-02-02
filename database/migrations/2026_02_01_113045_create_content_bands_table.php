<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_bands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('type'); // social_link, image, contact_button, text_block
            $table->integer('order')->default(0);
            $table->json('data')->nullable(); // Contenu spécifique au type
            $table->json('settings')->nullable(); // Paramètres visuels
            $table->timestamps();
            
            $table->index(['profile_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_bands');
    }
};
