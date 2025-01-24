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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hotel');
            $table->foreign('id_hotel')->references('id')->on('hotels')->onDelete('cascade');
            $table->enum('room_type', ['ESTANDAR', 'JUNIOR', 'SUITE']);  // 'ESTANDAR', 'JUNIOR', 'SUITE'
            $table->enum('accommodation', ['SENCILLA', 'DOBLE', 'TRIPLE', 'CUADRUPLE']);  // 'SENCILLA', 'DOBLE', 'TRIPLE', 'CUADRUPLE'
            $table->integer('amount');
            $table->unique(['id_hotel', 'room_type', 'accommodation']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropForeign('id_hotel');
        Schema::dropIfExists('rooms');
    }
};
