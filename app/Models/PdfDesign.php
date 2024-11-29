<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfDesign extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'pdf_designs';

    // Los campos que son asignables
    protected $fillable = [
        'header_logos',  // IDs de los logos para el encabezado
        'footer_logos',  // IDs de los logos para el pie de página
    ];

    // Convertir los campos de logos (que son arrays) a y desde formato JSON
    protected $casts = [
        'header_logos' => 'array',
        'footer_logos' => 'array',
    ];

    // Relación con los logos (si deseas obtener los detalles de los logos seleccionados)
    public function headerLogos()
    {
        return $this->belongsToMany(PdfLogo::class, 'pdf_design_logo', 'design_id', 'logo_id')
            ->wherePivot('position', 'header');  // Relación de logos en el encabezado
    }

    public function footerLogos()
    {
        return $this->belongsToMany(PdfLogo::class, 'pdf_design_logo', 'design_id', 'logo_id')
            ->wherePivot('position', 'footer');  // Relación de logos en el pie de página
    }
}
