<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_trabajo', function (Blueprint $table) {
            $table->increments('id_orden');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_vehiculo');
            $table->unsignedInteger('id_sucursal');
            $table->unsignedInteger('id_cita')->nullable()->comment('NULL si el ingreso fue directo');
            $table->unsignedInteger('id_usuario_registro')->comment('Recepcionista que crea la orden');
            $table->dateTime('fecha_ingreso')->useCurrent();
            $table->dateTime('fecha_entrega_estimada')->nullable();
            $table->enum('estado', ['RECIBIDA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'])->default('RECIBIDA');
            $table->text('diagnostico')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculo');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
            $table->foreign('id_cita')->references('id_cita')->on('cita');
            $table->foreign('id_usuario_registro')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_trabajo');
    }
};
