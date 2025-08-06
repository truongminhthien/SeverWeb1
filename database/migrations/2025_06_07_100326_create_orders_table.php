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
            $table->id('id_order');
            $table->unsignedBigInteger('id_voucher')->nullable();
            $table->foreign('id_voucher')->references('id_voucher')->on('vouchers')->onDelete('set null');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->integer('total_amount')->default(0);
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->enum('status', ['cart', 'ordered', 'preparing', 'shipping', 'delivered', 'cancelled'])->default('cart');
            $table->text('notes')->nullable();
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
