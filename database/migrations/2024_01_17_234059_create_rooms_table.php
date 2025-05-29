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
            $table->string('numero',4);
            $table->string('tipo',15);
            $table->text('detalles',3000);
            $table->string('vista', 4096);
            $table->integer('precio');
            $table->integer('precio_huesped');
            $table->integer('precio_noche_extra');
            $table->boolean('disponibilidad')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
