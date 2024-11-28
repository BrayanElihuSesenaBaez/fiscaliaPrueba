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
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstLastName')->nullable(); // Agrega la columna firstLastName
            $table->string('secondLastName')->nullable(); // Agrega la columna secondLastName
            $table->string('curp')->nullable(); // Agrega la columna CURP
            $table->date('birthDate')->nullable(); // Agrega la columna birthDate
            $table->string('phone')->nullable(); // Agrega la columna phone
            $table->string('state')->nullable(); // Agrega la columna state
            $table->string('municipality')->nullable(); // Agrega la columna municipality
            $table->string('colony')->nullable(); // Agrega la columna colony
            $table->string('code_postal')->nullable(); // Agrega la columna code_postal
            $table->string('street')->nullable(); // Agrega la columna street
            $table->string('rfc')->nullable(); // Agrega la columna RFC
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'firstLastName',
                'secondLastName',
                'curp',
                'birthDate',
                'phone',
                'state',
                'municipality',
                'colony',
                'code_postal',
                'street',
                'rfc',
            ]);
        });
    }
};
