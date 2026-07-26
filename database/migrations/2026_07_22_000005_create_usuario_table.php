<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->unsignedInteger('id_rol');
            $table->unsignedInteger('id_sucursal');
            $table->string('nombre_completo', 150);
            $table->string('email', 120);
            $table->string('password_hash', 255);
            $table->string('telefono', 20)->nullable();
            $table->boolean('estado')->default(true);
            $table->dateTime('fecha_creacion')->useCurrent();
            $table->foreign('id_rol')->references('id_rol')->on('rol');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
