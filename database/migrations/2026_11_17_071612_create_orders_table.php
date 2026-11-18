<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('delivery_method')->default('pickup'); // 'delivery' or 'pickup'
            $table->text('shipping_address')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('payment_method')->default('qris'); // 'qris', 'transfer_bank', 'cash'
            $table->string('payment_status')->default('unpaid'); // 'unpaid', 'pending_verification', 'paid', 'cancelled'
            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->string('order_status')->default('new'); // 'new', 'processing', 'ready', 'completed', 'cancelled'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
