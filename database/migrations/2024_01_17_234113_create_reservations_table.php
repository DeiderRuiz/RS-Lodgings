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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable(false);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('huespedes');
            $table->integer('noches');
            $table->integer('monto_habitacion');
            $table->integer('monto_extra_huesped');
            $table->integer('monto_noche_extra');
            $table->integer('monto_servicios');
            $table->string('estado')->default('pendiente');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
