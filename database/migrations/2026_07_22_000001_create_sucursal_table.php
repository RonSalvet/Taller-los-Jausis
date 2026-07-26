<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->increments('id_sucursal');
            $table->string('nombre', 100);
            $table->string('direccion', 200);
            $table->string('telefono', 20)->nullable();
            $table->string('zona', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sucursal');
    }
};
