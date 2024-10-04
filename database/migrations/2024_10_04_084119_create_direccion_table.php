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
        Schema::create('direccion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idCarpeta');
            $table->unsignedBigInteger('idPersona'); // Esto hace referencia a persona
            // Agrega los otros campos aquí...
            $table->foreign('idPersona')->references('id')->on('persona')->onDelete('cascade');

            $table->string('estado')->nullable();
            $table->string('municipio')->nullable();
            $table->string('localidad')->nullable();
            $table->string('colonia')->nullable();
            $table->string('calle')->nullable();
            $table->string('numExt')->nullable();
            $table->string('numInt')->nullable();
            $table->string('cp')->nullable();
            $table->string('tipoDireccion')->nullable();
            $table->string('notificaciones')->nullable();
            $table->string('dirNotificacion')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccion');
    }
};
