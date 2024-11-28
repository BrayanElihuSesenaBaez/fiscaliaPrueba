<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoAlignmentToPdfLogos extends Migration
{
    public function up(): void
    {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->string('alignment')->default('left')->after('file_path')->comment('Alineación del logo: left, center, right');
        });
    }

    public function down(): void
    {
        Schema::table('pdf_logos', function (Blueprint $table) {
            $table->dropColumn('alignment');
        });
    }
}
