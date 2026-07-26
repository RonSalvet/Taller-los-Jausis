<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permiso', function (Blueprint $table) {
            $table->increments('id_permiso');
            $table->string('codigo', 50);
            $table->string('descripcion', 200)->nullable();
            $table->string('modulo', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permiso');
    }
};
