<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->increments('id_vehiculo');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_modelo');
            $table->string('placa', 10);
            $table->unsignedSmallInteger('anio')->nullable();
            $table->string('color', 30)->nullable();
            $table->string('nro_chasis', 30)->nullable();
            $table->unsignedInteger('kilometraje')->default(0);
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            $table->foreign('id_modelo')->references('id_modelo')->on('modelo_vehiculo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
