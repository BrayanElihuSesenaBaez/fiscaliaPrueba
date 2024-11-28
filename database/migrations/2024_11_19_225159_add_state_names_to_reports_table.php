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
        Schema::table('reports', function (Blueprint $table) {
            $table->string('residence_state_name')->nullable();  // Campo para el nombre del estado de residencia
            $table->string('incident_state_name')->nullable();   // Campo para el nombre del estado del incidente
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['residence_state_name', 'incident_state_name']);
        });
    }

};
