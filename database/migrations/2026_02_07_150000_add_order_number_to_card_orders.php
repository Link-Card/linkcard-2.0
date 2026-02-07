<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $table->string('order_number', 10)->unique()->nullable()->after('id');
        });

        // Generate order numbers for existing orders
        $charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $orders = DB::table('card_orders')->whereNull('order_number')->get();
        foreach ($orders as $order) {
            do {
                $code = 'LC-';
                for ($i = 0; $i < 4; $i++) {
                    $code .= $charset[random_int(0, strlen($charset) - 1)];
                }
            } while (DB::table('card_orders')->where('order_number', $code)->exists());

            DB::table('card_orders')->where('id', $order->id)->update(['order_number' => $code]);
        }
    }

    public function down(): void
    {
        Schema::table('card_orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
};
