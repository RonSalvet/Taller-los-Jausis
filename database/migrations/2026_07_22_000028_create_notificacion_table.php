<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacion', function (Blueprint $table) {
            $table->bigIncrements('id_notificacion');
            $table->unsignedInteger('id_usuario')->nullable()->comment('Destinatario interno (opcional)');
            $table->unsignedInteger('id_cliente')->nullable()->comment('Destinatario cliente (opcional)');
            $table->string('mensaje', 255);
            $table->enum('canal', ['EMAIL', 'WHATSAPP', 'SISTEMA'])->default('SISTEMA');
            $table->dateTime('fecha_envio')->useCurrent();
            $table->boolean('leida')->default(false);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
