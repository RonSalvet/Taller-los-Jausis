<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago', function (Blueprint $table) {
            $table->increments('id_pago');
            $table->unsignedInteger('id_factura');
            $table->unsignedInteger('id_metodo');
            $table->unsignedInteger('id_usuario')->comment('Cajero que registra');
            $table->decimal('monto', 12, 2);
            $table->dateTime('fecha')->useCurrent();
            $table->string('referencia', 60)->nullable();
            $table->foreign('id_factura')->references('id_factura')->on('factura');
            $table->foreign('id_metodo')->references('id_metodo')->on('metodo_pago');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
