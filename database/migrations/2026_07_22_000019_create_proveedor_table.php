<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->increments('id_proveedor');
            $table->string('razon_social', 150);
            $table->string('nit', 20);
            $table->string('telefono', 20)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('direccion', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
