<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_bands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->integer('band_number')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['profile_id', 'band_number']);
        });

        Schema::create('band_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('band_id')->constrained('image_bands')->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->string('link')->nullable();
            $table->string('align')->default('center');
            $table->integer('spacing_px')->default(0);
            $table->string('text')->nullable();
            $table->boolean('custom_height')->default(false);
            $table->integer('height_px')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('band_images');
        Schema::dropIfExists('image_bands');
    }
};
