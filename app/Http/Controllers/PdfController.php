<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\PdfLogo;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf($reportId){
        $report = Report::with(['category', 'subcategory'])->findOrFail($reportId);

        $logos = PdfLogo::where('is_active', 1)->get();

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

            'logos' => $logos,
        ];

        $pdf = Pdf::loadView('pdf.view', $data);

        return $pdf->download('reporte_' . $report->expedient_number . '.pdf');
    }

    public function viewPdf($id)
    {
        $report = Report::findOrFail($id);

        if (!$report->pdf_blob) {
            return redirect()->route('dashboard')->withErrors('El PDF no está disponible.');
        }

        return response($report->pdf_blob)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="reporte_' . $report->id . '.pdf"');
    }

    public function downloadPdf(Report $report)
    {
        if ($report->pdf_blob) {
            return response()->streamDownload(function () use ($report) {
                echo $report->pdf_blob;
            }, 'reporte_' . $report->expedient_number . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="reporte_' . $report->expedient_number . '.pdf"'
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'No se ha generado el PDF para este reporte.');
        }
    }

}







