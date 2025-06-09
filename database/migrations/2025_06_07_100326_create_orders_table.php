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
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->decimal('total_amount', 10, 2);
            $table->string('customer_name');
            $table->string('phone');
            $table->string('address');
            $table->string('payment_method');
            $table->text('notes')->nullable();
            $table->enum('status', ['cart', 'preparing', 'shipping', 'delivered'])->default('cart');
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
