<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_orden', function (Blueprint $table) {
            $table->increments('id_detalle');
            $table->unsignedInteger('id_orden');
            $table->unsignedInteger('id_servicio');
            $table->unsignedSmallInteger('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->enum('estado', ['PENDIENTE', 'EN_PROCESO', 'CONCLUIDO'])->default('PENDIENTE');
            $table->foreign('id_orden')->references('id_orden')->on('orden_trabajo')->cascadeOnDelete();
            $table->foreign('id_servicio')->references('id_servicio')->on('servicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_orden');
    }
};
