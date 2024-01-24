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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_inicio_cita');
            $table->dateTime('fecha_fin_cita');
            $table->enum('estado', ['pendiente', 'confirmada','cancelada','completada'])->default('pendiente');
            $table->string('placa');
            $table->string('nombre_propie');
            $table->string('cilindraje');
            $table->enum('servicio', ['mantenimiento','diagnostico']);
            $table->text('descripcion');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipo_vehiculo');
            $table->timestamps();
            $table->foreign('tipo_vehiculo')->references('id')->on('tipo_vehiculos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
