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
            $table->dropColumn(['state', 'municipality']);
            $table->foreignId('state_id')->constrained()->onDelete('cascade');
            $table->foreignId('municipality_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
