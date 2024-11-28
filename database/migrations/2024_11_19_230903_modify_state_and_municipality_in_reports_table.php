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
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->change(); // Permitir NULL
            $table->unsignedBigInteger('municipality_id')->nullable()->change(); // Permitir NULL
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable(false)->change(); // Volver a NO NULL
            $table->unsignedBigInteger('municipality_id')->nullable(false)->change(); // Volver a NO NULL
        });
    }

};
