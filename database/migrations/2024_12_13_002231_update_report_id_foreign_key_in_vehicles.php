<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Elimina la clave foránea existente
            $table->dropForeign(['report_id']);

            // Elimina la columna si es necesario (comenta o descomenta esta línea si lo necesitas)
            // $table->dropColumn('report_id');

            // Vuelve a definir la clave foránea correctamente
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Elimina la clave foránea en caso de rollback
            $table->dropForeign(['report_id']);
        });
    }
};
