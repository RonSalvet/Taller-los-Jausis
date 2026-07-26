<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->increments('id_cita');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_vehiculo');
            $table->unsignedInteger('id_sucursal');
            $table->dateTime('fecha_hora');
            $table->string('motivo', 255)->nullable();
            $table->enum('estado', ['PENDIENTE', 'CONFIRMADA', 'CANCELADA', 'ATENDIDA'])->default('PENDIENTE');
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculo');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cita');
    }
};
