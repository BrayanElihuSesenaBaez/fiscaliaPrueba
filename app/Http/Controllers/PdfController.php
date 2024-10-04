<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de tener esto
use Illuminate\Http\Request;
use App\Models\Report;

class PdfController extends Controller
{
    public function generatePdf($reportId)
    {
        // Obtener el reporte completo
        $report = Report::with(['category', 'subcategory', 'institution'])->findOrFail($reportId);

        $data = [
            'report_date' => $report->report_date,
            'expedient_number' => $report->expedient_number,
            'last_name' => $report->last_name,
            'mother_last_name' => $report->mother_last_name,
            'first_name' => $report->first_name,
            'institution_name' => $report->institution ? $report->institution->name : 'No asignada',
            'rank' => $report->rank,
            'unit' => $report->unit,
            'description' => $report->description,
            'category' => $report->category,
            'subcategory' => $report->subcategory,
            // Agrega otros datos que quieras incluir en el PDF
        ];

        // Cargar la vista para el PDF
        $pdf = Pdf::loadView('pdf.view', $data);
        return $pdf->download('reporte.pdf');
    }
}






