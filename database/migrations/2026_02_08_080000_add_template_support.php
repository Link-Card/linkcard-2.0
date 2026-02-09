<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Template config overrides (for Custom template #13)
            if (!Schema::hasColumn('profiles', 'template_config')) {
                $table->json('template_config')->nullable()->after('template_id');
            }
            // Custom text color
            if (!Schema::hasColumn('profiles', 'text_color')) {
                $table->string('text_color')->nullable()->after('secondary_color');
            }
            // Custom button color
            if (!Schema::hasColumn('profiles', 'button_color')) {
                $table->string('button_color')->nullable()->after('text_color');
            }
        });

        // Update default template_id from 'default' to 'classic'
        \DB::table('profiles')
            ->where('template_id', 'default')
            ->orWhereNull('template_id')
            ->update(['template_id' => 'classic']);

        // Add new content band types: video_embed, image_carousel, cta_button
        // The content_bands.type is an ENUM — we need to modify it
        \DB::statement("ALTER TABLE content_bands MODIFY COLUMN type ENUM('social_link', 'image', 'text_block', 'contact_button', 'video_embed', 'image_carousel', 'cta_button') NOT NULL");
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['template_config', 'text_color', 'button_color']);
        });

        \DB::statement("ALTER TABLE content_bands MODIFY COLUMN type ENUM('social_link', 'image', 'text_block', 'contact_button') NOT NULL");
    }
};
