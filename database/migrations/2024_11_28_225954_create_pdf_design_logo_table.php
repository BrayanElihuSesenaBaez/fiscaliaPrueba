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
        Schema::create('pdf_design_logo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('design_id')->constrained('pdf_designs')->onDelete('cascade');
            $table->foreignId('logo_id')->constrained('pdf_logos')->onDelete('cascade');
            $table->enum('position', ['header', 'footer']);  // Para saber si es encabezado o pie de página
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_design_logo');
    }
};
