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
        Schema::create('pdf_designs', function (Blueprint $table) {
            $table->id();
            $table->json('header_logos')->nullable(); // Almacenamos los IDs de los logos para el encabezado
            $table->json('footer_logos')->nullable(); // Almacenamos los IDs de los logos para el pie de página
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_designs');
    }
};
