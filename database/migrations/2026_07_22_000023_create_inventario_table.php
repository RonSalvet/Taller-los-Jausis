<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->increments('id_inventario');
            $table->unsignedInteger('id_repuesto');
            $table->unsignedInteger('id_sucursal');
            $table->unsignedInteger('stock_actual')->default(0);
            $table->unsignedInteger('stock_minimo')->default(5);
            $table->string('ubicacion', 60)->nullable();
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
