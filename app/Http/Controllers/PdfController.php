<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\PdfLogo;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class PdfController extends Controller
{
    public function generatePdf($reportId)
    {
        // Obtiene el reporte completo incluyendo las relaciones de categoria y subcategoria
        $report = Report::with(['category', 'subcategory'])->findOrFail($reportId);

        $logos = PdfLogo::all();
        $logosDetails = $logos->map(function ($logo) {
            $logo->absolute_path = public_path('storage/' . $logo->file_path);
            return $logo;
        });


        dd($logosDetails);

        foreach ($logosDetails as $logo) {
            if (!empty($logo->absolute_path)) {
                if (!file_exists($logo->absolute_path)) {
                    dd("Archivo no encontrado: " . $logo->absolute_path);
                }
            }
        }

        // Crear una instancia de TCPDF
        $pdf = new TCPDF();

        // Configuración inicial del PDF
        $pdf->SetMargins(15, 20, 15); // Márgenes
        $pdf->AddPage();

        // Datos necesarios para la vista del PDF
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
            'residence_state' => $report->residence_state,
            'residence_municipality' => $report->residence_municipality,
            'residence_code_postal' => $report->residence_code_postal,
            'residence_colony' => $report->residence_colony,
            'residence_city' => $report->residence_city,
            'incident_city' => $report->incident_city,
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
            'has_witnesses' => $report->has_witnesses ? 'Sí' : 'No',
            'witnesses' => is_array($report->witnesses) ? $report->witnesses : [],
            'emergency_call' => $report->emergency_call,
            'emergency_number' => $report->emergency_number,
            'detailed_account' => $report->detailed_account,
            'category_name' => $report->category->name,
            'subcategory_name' => $report->subcategory->name,
            'logosDetails' => $logosDetails,
        ];

        $pdf = new \TCPDF();
        $pdf->AddPage();

        $html = view('pdf.view', $data)->render();
        dd($html); // Inspecciona el HTML antes de escribirlo al PDF

        $pdf->writeHTML($html);

        foreach ($logosDetails as $logo) {
            if (!empty($logo->absolute_path)) {
                \Log::info('Procesando logotipo', [
                    'ruta' => $logo->absolute_path,
                    'coordenadas' => [
                        'x' => $logo->position_x,
                        'y' => $logo->position_y,
                        'width' => $logo->width,
                        'height' => $logo->height,
                    ],
                    'existe' => file_exists($logo->absolute_path) ? 'Sí' : 'No',
                ]);

                $pdf->Image(
                    $logo->absolute_path,
                    $logo->position_x,
                    $logo->position_y,
                    $logo->width,
                    $logo->height
                );
            }
        }

        return $pdf->Output('reporte_' . $report->expedient_number . '.pdf', 'D');
    }
}







