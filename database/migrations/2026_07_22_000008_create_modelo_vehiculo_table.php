<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modelo_vehiculo', function (Blueprint $table) {
            $table->increments('id_modelo');
            $table->unsignedInteger('id_marca');
            $table->string('nombre', 60);
            $table->string('tipo_motor', 40)->nullable();
            $table->string('cilindrada', 20)->nullable();
            $table->foreign('id_marca')->references('id_marca')->on('marca_vehiculo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelo_vehiculo');
    }
};
