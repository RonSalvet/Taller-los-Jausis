<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mecanico', function (Blueprint $table) {
            $table->increments('id_mecanico');
            $table->unsignedInteger('id_sucursal');
            $table->string('nombre', 150);
            $table->string('ci', 20);
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_contratacion')->nullable();
            $table->boolean('disponibilidad')->default(true);
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mecanico');
    }
};
