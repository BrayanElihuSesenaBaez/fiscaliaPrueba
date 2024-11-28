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
        Schema::create('witnesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id'); // Clave foránea que relaciona al reporte
            $table->string('full_name');              // Nombre completo del testigo
            $table->string('phone')->nullable();                   // Número de teléfono del testigo
            $table->string('relationship')->nullable();            // Parentesco con la víctima
            $table->text('incident_description')->nullable();      // Descripción del suceso
            $table->timestamps();

            // Define la relación con la tabla reports
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witnesses');
    }
};
