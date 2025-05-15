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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_color')->default('#f2f3f5');
            $table->string('text_color')->default('#000000');
            $table->string('button_color')->default('#9B1B30');
            $table->string('btn_primary')->default('#9B1B30');
            $table->string('login_button_color')->default('#9B1B30');
            $table->string('login_text_color')->default('#9B1B30');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};


/*ya cree el archivo ya solo que tu hagas la migración haber si así lo jala*/
