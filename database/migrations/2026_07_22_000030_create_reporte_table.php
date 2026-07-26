<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte', function (Blueprint $table) {
            $table->increments('id_reporte');
            $table->unsignedInteger('id_usuario');
            $table->enum('tipo', ['INGRESOS', 'SERVICIOS', 'MECANICOS', 'INVENTARIO']);
            $table->dateTime('fecha_generacion')->useCurrent();
            $table->json('parametros')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte');
    }
};
