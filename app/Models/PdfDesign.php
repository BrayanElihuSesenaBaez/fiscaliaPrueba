<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfDesign extends Model
{
    use HasFactory;

    protected $table = 'pdf_designs';

    protected $fillable = [
        'header_logos',
        'footer_logos',
    ];

    protected $casts = [
        'header_logos' => 'array',
        'footer_logos' => 'array',
    ];

    public function headerLogos()
    {
        return $this->belongsToMany(PdfLogo::class, 'pdf_design_logo', 'design_id', 'logo_id')
            ->wherePivot('position', 'header');
    }

    public function footerLogos()
    {
        return $this->belongsToMany(PdfLogo::class, 'pdf_design_logo', 'design_id', 'logo_id')
            ->wherePivot('position', 'footer');
    }
}
