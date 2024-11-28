<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    //Crea tabla 'reports'
    public function up(): void{
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('expedient_number')->unique(); // Número de expediente inico
            $table->dateTime('report_date');
            $table->string('pdf_path')->nullable(); // Ruta del PDF

            // Página 1: Datos del denunciante y domicilio
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mother_last_name');
            $table->date('birth_date');
            $table->string('gender');
            $table->string('education');
            $table->string('birth_place');
            $table->integer('age');
            $table->string('civil_status');
            $table->string('curp');
            $table->string('phone');
            $table->string('email');
            $table->string('state');
            $table->string('municipality');
            $table->string('street');

            $table->string('residence_code_postal');
            $table->string('residence_colony');
            $table->string('residence_city')->nullable(); // Ciudad es opcional


            $table->string('ext_number');
            $table->string('int_number')->nullable();

            // Página 2: Datos del delito y domicilio
            $table->dateTime('incident_date_time');
            $table->string('incident_state');
            $table->string('incident_municipality');
            $table->string('incident_colony');
            $table->string('incident_code_postal');
            $table->string('incident_street');

            // Campos para la incidencia
            $table->string('incident_city')->nullable(); // Ciudad del incidente

            $table->string('incident_ext_number');
            $table->string('incident_int_number')->nullable();

            // Página 3: Relato de los hechos y categorías
            $table->string('suffered_damage');
            $table->string('witnesses');
            $table->string('emergency_call');
            $table->string('emergency_number')->nullable();
            $table->text('detailed_account');
            $table->unsignedBigInteger('category_id');
            $table->string('category_name')->nullable();
            $table->unsignedBigInteger('subcategory_id');
            $table->string('subcategory_name')->nullable();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories'); //Establece una  relación con la tabla 'categories'
            $table->foreign('subcategory_id')->references('id')->on('subcategories');//Establece relación con tabla 'subcategories'
            $table->timestamps();
        });

    }

    public function down(){
        Schema::dropIfExists('reports');
    }
};
