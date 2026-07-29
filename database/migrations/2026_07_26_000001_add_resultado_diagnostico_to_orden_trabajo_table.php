<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            $table->enum('resultado_diagnostico', ['REPARABLE', 'REQUIERE_REPUESTO', 'NO_REPARABLE'])
                ->nullable()
                ->after('diagnostico');
        });
    }

    public function down(): void
    {
        Schema::table('orden_trabajo', function (Blueprint $table) {
            $table->dropColumn('resultado_diagnostico');
        });
    }
};
