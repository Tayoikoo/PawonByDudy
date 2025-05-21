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
        Schema::create('order', function (Blueprint $table) {
            $table->unsignedBigInteger('id_order')->primary(true); 
            $table->unsignedBigInteger('id_user')->nullable(); 
            $table->string('metode_pembayaran', 16);
            $table->string('status', 16); // Proses & Selesai
            $table->double('total_harga'); 
            $table->text('alamat')->nullable(); 
            $table->string('pos', 12)->nullable();             
            $table->date('tanggal_pemesanan');
            $table->unsignedBigInteger('id_pengirim')->nullable(); 
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_pengirim')->references('id_pengirim')->on('pengirim')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
