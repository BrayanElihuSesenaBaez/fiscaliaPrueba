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
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_vehiculo_id')->nullable();
            $table->string('procedenciaVehiculo')->nullable();
            $table->string('estadoPlaca')->nullable();
            $table->string('numeroSerie')->nullable();
            $table->string('tipoVehiculo')->nullable();
            $table->string('placa')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('NRPV')->nullable();
            $table->string('placaPermiso')->nullable();
            $table->string('submarca')->nullable();
            $table->string('color')->nullable();
            $table->string('tipoUso')->nullable();
            $table->string('placaExtranjera')->nullable();
            $table->string('numeroMotor')->nullable();
            $table->string('clase')->nullable();
            $table->string('aseguradora')->nullable();
            $table->string('senasParticulares')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
