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
            // Agregar el campo 'has_witnesses' con valor predeterminado "No"
            $table->string('has_witnesses')->default('No');

            // Agregar el campo 'witnesses' como JSON
            $table->json('witnesses')->nullable();
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            // Eliminar los campos si se revierte la migración
            $table->dropColumn('has_witnesses');
            $table->dropColumn('witnesses');
        });
    }
};
