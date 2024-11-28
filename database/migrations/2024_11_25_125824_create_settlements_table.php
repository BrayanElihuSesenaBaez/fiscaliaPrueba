<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('zip_code_id');
            $table->unsignedBigInteger('settlement_type_id');
            $table->foreign('zip_code_id')->references('id')->on('zip_codes')->onDelete('cascade');
            $table->foreign('settlement_type_id')->references('id')->on('settlement_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
