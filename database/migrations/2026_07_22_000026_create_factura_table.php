<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->increments('id_factura');
            $table->unsignedInteger('id_orden');
            $table->string('numero', 20);
            $table->string('nit_ci', 20);
            $table->string('razon_social', 150);
            $table->dateTime('fecha_emision')->useCurrent();
            $table->decimal('monto_total', 12, 2);
            $table->enum('estado', ['EMITIDA', 'PAGADA', 'ANULADA'])->default('EMITIDA');
            $table->foreign('id_orden')->references('id_orden')->on('orden_trabajo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
