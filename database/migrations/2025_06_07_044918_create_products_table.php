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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->unsignedBigInteger('id_category');
            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('price');
            $table->string('gender')->nullable();
            $table->integer('volume')->nullable();
            $table->string('type')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('views')->default(0);
            $table->decimal('discount', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('inactive');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
