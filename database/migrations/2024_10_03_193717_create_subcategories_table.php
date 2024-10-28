<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    //Crea la tabla 'subcategories'
    public function up(): void{
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); //Clave foranea que referencia a 'categories'
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('subcategories');
    }
};
