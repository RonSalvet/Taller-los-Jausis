<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mecanico_especialidad', function (Blueprint $table) {
            $table->unsignedInteger('id_mecanico');
            $table->unsignedInteger('id_especialidad');
            $table->date('fecha_certificacion')->nullable();
            $table->primary(['id_mecanico', 'id_especialidad']);
            $table->foreign('id_mecanico')->references('id_mecanico')->on('mecanico')->cascadeOnDelete();
            $table->foreign('id_especialidad')->references('id_especialidad')->on('especialidad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mecanico_especialidad');
    }
};
