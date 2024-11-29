<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfLogo extends Model
{
    use HasFactory;

    protected $table = 'pdf_logos';

    protected $fillable = [
        'name',
        'file_path',
        'alignment',
        'position_x',
        'position_y',
        'width',
        'height',
        'location',
        'section',
        'image_data',
    ];
}
