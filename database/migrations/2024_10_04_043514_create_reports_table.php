<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void{
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time')->default(now()); // Asigna la fecha y hora actual como valor predeterminado
            $table->string('expedient_number'); // Número de expediente
            $table->string('last_name'); // Apellido Paterno
            $table->string('mother_last_name'); // Apellido Materno
            $table->string('first_name'); // Nombre(s)
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->onDelete('set null');
            $table->string('rank')->nullable(); // Grado o rango
            $table->string('unit')->nullable(); // Unidad de intervención
            $table->string('description');
            $table->date('report_date');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->string('pdf_path')->nullable(); // Agregar la columna para la ruta del PDF
            // Mas campos para agregar
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('reports');
    }
};
