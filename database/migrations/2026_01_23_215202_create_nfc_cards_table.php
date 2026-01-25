<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nfc_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('profile_id')->nullable()->constrained()->onDelete('set null');
            
            // Informations carte
            $table->string('card_number')->unique(); // Numéro unique gravé sur carte
            $table->string('card_type')->default('standard'); // standard, premium, custom
            $table->string('nfc_uid')->unique()->nullable(); // UID puce NFC
            
            // Statut
            $table->enum('status', [
                'ordered',     // Commandée
                'produced',    // En production
                'shipped',     // Expédiée
                'delivered',   // Livrée
                'activated',   // Activée par l'utilisateur
                'deactivated', // Désactivée
                'lost',        // Perdue (déclarée)
                'replaced'     // Remplacée
            ])->default('ordered');
            
            // Informations commande
            $table->decimal('price', 8, 2)->nullable();
            $table->string('order_number')->nullable();
            $table->string('tracking_number')->nullable();
            
            // Adresse de livraison (snapshot au moment de la commande)
            $table->json('shipping_address')->nullable();
            // {
            //   "name": "...",
            //   "street": "...",
            //   "city": "...",
            //   "province": "...",
            //   "postal_code": "...",
            //   "country": "CA"
            // }
            
            // Design personnalisé (si option premium)
            $table->string('design_file')->nullable();
            $table->text('design_notes')->nullable();
            
            // Dates importantes
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            
            // Statistiques d'utilisation
            $table->integer('tap_count')->default(0);
            $table->timestamp('last_tapped_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('user_id');
            $table->index('profile_id');
            $table->index('card_number');
            $table->index('nfc_uid');
            $table->index('status');
            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfc_cards');
    }
};
