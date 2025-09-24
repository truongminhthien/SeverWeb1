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
        Schema::create('address', function (Blueprint $table) {
            $table->id('id_address');
            $table->unsignedBigInteger('id_user');
            $table->string('recipient_name');
            $table->string('phone');
            $table->string('address_line');
            $table->string('status')->default('default')->comment('default, non-default, deleted');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
        Schema::dropIfExists('users');
    }
};
