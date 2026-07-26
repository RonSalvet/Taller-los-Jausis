<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicio', function (Blueprint $table) {
            $table->increments('id_servicio');
            $table->unsignedInteger('id_tipo_servicio');
            $table->string('nombre', 100);
            $table->string('descripcion', 255)->nullable();
            $table->decimal('precio_base', 10, 2);
            $table->unsignedSmallInteger('tiempo_estimado')->nullable()->comment('Minutos');
            $table->boolean('estado')->default(true);
            $table->foreign('id_tipo_servicio')->references('id_tipo_servicio')->on('tipo_servicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
