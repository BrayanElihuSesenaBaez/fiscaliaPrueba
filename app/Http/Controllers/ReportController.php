<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Institution;

class ReportController extends Controller
{
    public function create()
    {
        // Obtener todas las instituciones y categorías
        $institutions = Institution::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('reports.create', compact('institutions', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'report_date' => 'required|date',
            'expedient_number' => 'required|string',
            'last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'first_name' => 'required|string',
            'institution_id' => 'required|exists:institutions,id',
            'rank' => 'nullable|string',
            'unit' => 'nullable|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Crear el reporte con date_time como la fecha y hora actual
        $report = Report::create([
            'date_time' => now(), // Asignar la fecha y hora actual
            'report_date' => $request->report_date,
            'expedient_number' => $request->expedient_number,
            'last_name' => $request->last_name,
            'mother_last_name' => $request->mother_last_name,
            'first_name' => $request->first_name,
            'institution_id' => $request->institution_id,
            'rank' => $request->rank,
            'unit' => $request->unit,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);

        // Redirigir para generar el PDF
        return redirect()->route('reports.pdf', ['reportId' => $report->id]);
    }

    public function generatePdf($reportId)
    {
        // Obtener el reporte completo junto con las relaciones
        $report = Report::with(['category', 'subcategory', 'institution'])->findOrFail($reportId);

        // Pasar los datos a la vista del PDF
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
        ];

        // Cargar la vista para el PDF
        $pdf = Pdf::loadView('pdf.view', $data);
        return $pdf->download('reporte.pdf');
    }

}



