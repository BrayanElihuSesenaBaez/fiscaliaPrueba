<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->binary('image_data')->nullable(); // Columna para los datos binarios
        });
    }

    public function down(): void
    {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->dropColumn('image_data');
        });
    }
};
