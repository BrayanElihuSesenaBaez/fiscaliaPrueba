<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            //Campos nuevos agregados
            $table->string('firstLastName', 25)->nullable();
            $table->string('secondLastName', 25)->nullable();
            $table->string('curp', 18)->nullable();
            $table->date('birthDate')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('state')->nullable();
            $table->string('municipality')->nullable();
            $table->string('colony')->nullable();
            $table->string('code_postal', 5)->nullable();
            $table->string('street')->nullable();
            $table->string('rfc', 13)->unique()->nullable();
            $table->foreignId('idRol')->constrained('roles');
            $table->string('cargo');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('users');
    }
};
