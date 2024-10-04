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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('primerApellido');
            $table->string('segundoApellido');
            $table->string('nombre');
            $table->string('alias')->nullable();
            $table->string('calidadJuridica')->nullable();
            $table->string('tipoInformacion')->nullable();
            $table->string('cargo')->nullable();
            $table->string('dependencia')->nullable();
            $table->string('lugarNacimiento')->nullable();
            $table->date('fechaNacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('sexo')->nullable();
            $table->foreignId('estadoCivil')->constrained('cat_estado_civil');
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('escolaridad')->nullable();
            $table->foreignId('religion')->constrained('cat_religion');
            $table->string('ocupacion')->nullable();
            $table->string('trabajo')->nullable();
            $table->string('direccionTrabajo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
