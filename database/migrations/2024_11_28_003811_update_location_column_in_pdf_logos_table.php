<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->string('location')->default('pending')->change(); // Usa 'string' en lugar de 'enum'
        });
    }

    public function down() {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->string('location')->default('header')->change(); // También cambia a 'string' en el down
        });
    }

};
