<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repuesto', function (Blueprint $table) {
            $table->increments('id_repuesto');
            $table->string('codigo', 30);
            $table->string('nombre', 120);
            $table->string('descripcion', 255)->nullable();
            $table->string('marca', 60)->nullable();
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repuesto');
    }
};
