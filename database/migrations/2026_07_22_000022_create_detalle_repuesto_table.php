<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_repuesto', function (Blueprint $table) {
            $table->unsignedInteger('id_detalle');
            $table->unsignedInteger('id_repuesto');
            $table->unsignedSmallInteger('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 12, 2);
            $table->primary(['id_detalle', 'id_repuesto']);
            $table->foreign('id_detalle')->references('id_detalle')->on('detalle_orden')->cascadeOnDelete();
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_repuesto');
    }
};
