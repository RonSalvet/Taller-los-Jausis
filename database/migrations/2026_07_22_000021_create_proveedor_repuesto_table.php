<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedor_repuesto', function (Blueprint $table) {
            $table->unsignedInteger('id_proveedor');
            $table->unsignedInteger('id_repuesto');
            $table->decimal('precio_referencial', 10, 2)->nullable();
            $table->primary(['id_proveedor', 'id_repuesto']);
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->cascadeOnDelete();
            $table->foreign('id_repuesto')->references('id_repuesto')->on('repuesto')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor_repuesto');
    }
};
