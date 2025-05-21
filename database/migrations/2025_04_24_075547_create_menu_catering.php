<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // MC01
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_catering', function (Blueprint $table) {
            $table->id('id_catering');
            $table->string("nama", 128);
            $table->text("deskripsi");
            $table->double("harga");
            $table->string("foto")->nullable();
            $table->boolean("status")->default(0);
            $table->unsignedBigInteger('id_paket');
            $table->foreign('id_paket')->references('id_paket')->on('paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_catering');
    }
};
