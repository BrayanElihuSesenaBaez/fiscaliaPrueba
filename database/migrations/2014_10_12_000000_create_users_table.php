<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstLastName');
            $table->string('secondLastName ');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('idRol')->constrained('rol');
            $table->string('cargo');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('users');
    }
};
