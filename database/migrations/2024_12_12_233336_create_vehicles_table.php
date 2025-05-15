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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
            $table->string('marca');
            $table->string('modelo');
            $table->string('numeroSerie');
            $table->string('numeroMotor');
            $table->string('tipoUso');
            $table->string('color');
            $table->string('placa');
            $table->string('estadoPlaca');
            $table->string('placaExtranjera')->nullable();
            $table->string('submarca');
            $table->string('procedenciaVehiculo');
            $table->string('NRPV')->nullable();
            $table->string('placaPermiso')->nullable();
            $table->string('clase')->nullable();
            $table->string('aseguradora')->nullable();
            $table->string('señasParticulares')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
