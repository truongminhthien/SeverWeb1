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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('id_voucher');
            $table->string('code')->unique();
            $table->integer('discount_amount')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('min_order_amount')->default(0);
            $table->integer('max_discount_amount')->nullable();
            $table->integer('usage_limit')->default(0);
            $table->string('description')->nullable();
            $table->string('note')->nullable();
            $table->enum('type', ['percentage', 'fixed'])->default('fixed');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
