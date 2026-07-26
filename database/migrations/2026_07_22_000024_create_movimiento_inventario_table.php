<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimiento_inventario', function (Blueprint $table) {
            $table->bigIncrements('id_movimiento');
            $table->unsignedInteger('id_inventario');
            $table->unsignedInteger('id_usuario');
            $table->enum('tipo', ['ENTRADA', 'SALIDA', 'AJUSTE']);
            $table->integer('cantidad');
            $table->dateTime('fecha')->useCurrent();
            $table->string('motivo', 200)->nullable();
            $table->foreign('id_inventario')->references('id_inventario')->on('inventario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimiento_inventario');
    }
};
