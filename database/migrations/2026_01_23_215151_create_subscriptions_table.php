<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Plan d'abonnement
            $table->enum('plan', [
                'free',        // Gratuit (limité)
                'basic',       // 4.99$/mois
                'pro',         // 9.99$/mois
                'enterprise'   // 29.99$/mois
            ])->default('free');
            
            // Informations Stripe
            $table->string('stripe_customer_id')->nullable()->unique();
            $table->string('stripe_subscription_id')->nullable()->unique();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_payment_method_id')->nullable();
            
            // Statut
            $table->enum('status', [
                'active',      // Actif
                'canceled',    // Annulé
                'past_due',    // Paiement en retard
                'unpaid',      // Non payé
                'incomplete',  // Paiement incomplet
                'trialing'     // En période d'essai
            ])->default('active');
            
            // Dates importantes
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            
            // Billing
            $table->string('billing_interval')->default('monthly'); // monthly, yearly
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('currency', 3)->default('CAD');
            
            // Limites du plan
            $table->integer('max_profiles')->default(1);
            $table->integer('max_modules_per_profile')->default(5);
            $table->boolean('analytics_enabled')->default(false);
            $table->boolean('custom_domain_enabled')->default(false);
            $table->boolean('nfc_cards_enabled')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('user_id');
            $table->index('stripe_customer_id');
            $table->index('stripe_subscription_id');
            $table->index('status');
            $table->index('plan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
