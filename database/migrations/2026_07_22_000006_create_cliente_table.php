<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('nombre', 150);
            $table->string('ci_nit', 20);
            $table->string('telefono', 20);
            $table->string('email', 120)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->date('fecha_registro');
            $table->boolean('estado')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
