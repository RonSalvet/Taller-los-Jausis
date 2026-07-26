<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->bigIncrements('id_auditoria');
            $table->unsignedInteger('id_usuario');
            $table->string('tabla', 60);
            $table->enum('accion', ['CREAR', 'MODIFICAR', 'ELIMINAR', 'ANULAR']);
            $table->dateTime('fecha_hora')->useCurrent();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
