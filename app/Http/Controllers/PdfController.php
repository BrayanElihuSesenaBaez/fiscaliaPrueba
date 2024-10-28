<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Report;

class PdfController extends Controller
{
    public function generatePdf($reportId){
        // Obtiene el reporte completo incluyendo las relaciones de categoria y subcategoria
        $report = Report::with(['category', 'subcategory'])->findOrFail($reportId);

        //Datos necesarios para la vista del PDF
        $data = [
            'report_date' => $report->report_date,
            'expedient_number' => $report->expedient_number,
            'last_name' => $report->last_name,
            'mother_last_name' => $report->mother_last_name,
            'first_name' => $report->first_name,
            'birth_date' => $report->birth_date,
            'gender' => $report->gender,
            'education' => $report->education,
            'birth_place' => $report->birth_place,
            'age' => $report->age,
            'civil_status' => $report->civil_status,
            'curp' => $report->curp,
            'phone' => $report->phone,
            'email' => $report->email,
            'state' => $report->state,
            'municipality' => $report->municipality,
            'colony' => $report->colony,
            'code_postal' => $report->code_postal,
            'street' => $report->street,
            'ext_number' => $report->ext_number,
            'int_number' => $report->int_number,
            'incident_date_time' => $report->incident_date_time,
            'incident_state' => $report->incident_state,
            'incident_municipality' => $report->incident_municipality,
            'incident_colony' => $report->incident_colony,
            'incident_code_postal' => $report->incident_code_postal,
            'incident_street' => $report->incident_street,
            'incident_ext_number' => $report->incident_ext_number,
            'incident_int_number' => $report->incident_int_number,
            'suffered_damage' => $report->suffered_damage,
            'witnesses' => $report->witnesses,
            'emergency_call' => $report->emergency_call,
            'emergency_number' => $report->emergency_number,
            'detailed_account' => $report->detailed_account,
            'category_name' => $report->category->name,
            'subcategory_name' => $report->subcategory->name,

        ];

        // Genera el PDF a partir de la vista 'pdf.view' y los datos
        $pdf = Pdf::loadView('pdf.view', $data);

        //Descarga el PDF con el nombre basado en el numero de expediente del reporte
        return $pdf->download('reporte_' . $report->expedient_number . '.pdf');
    }
}






