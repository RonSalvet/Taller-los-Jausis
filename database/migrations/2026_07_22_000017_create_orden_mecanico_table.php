<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orden_mecanico', function (Blueprint $table) {
            $table->unsignedInteger('id_orden');
            $table->unsignedInteger('id_mecanico');
            $table->dateTime('fecha_asignacion')->useCurrent();
            $table->primary(['id_orden', 'id_mecanico']);
            $table->foreign('id_orden')->references('id_orden')->on('orden_trabajo')->cascadeOnDelete();
            $table->foreign('id_mecanico')->references('id_mecanico')->on('mecanico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_mecanico');
    }
};
