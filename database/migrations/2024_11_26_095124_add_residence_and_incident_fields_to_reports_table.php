<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {

            // Nuevos campos para la residencia
            $table->string('residence_code_postal');
            $table->string('residence_colony');
            $table->string('residence_city')->nullable(); // Ciudad es opcional

            // Campos para la incidencia
            $table->string('incident_city')->nullable(); // Ciudad del incidente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
