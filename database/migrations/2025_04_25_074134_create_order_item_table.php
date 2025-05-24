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
        Schema::create('order_item', function (Blueprint $table) {
            $table->id('id_item'); 
            $table->unsignedBigInteger('id_order'); 
            $table->unsignedBigInteger('id_catering'); 
            $table->integer('jumlah');
            $table->double('harga');
            $table->foreign('id_order')->references('id_order')->on('order')->onDelete('cascade'); 
            $table->foreign('id_catering')->references('id_catering')->on('menu_catering')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item');
    }
};
