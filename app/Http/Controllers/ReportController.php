<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Institution;

class ReportController extends Controller{
    // Mostrar la lista de reportes filtrados (para el Fiscal General)
    public function index(Request $request)
    {
        $query = Report::query();

        // Filtrar por palabras clave (fecha, número de expediente, nombre de la víctima)
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('expedient_number', 'like', "%{$keyword}%")
                ->orWhere('report_date', 'like', "%{$keyword}%")
                ->orWhere('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%");
        }

        // Obtener los reportes filtrados
        $reports = $query->get();

        return view('dashboard', compact('reports'));
    }

    // Mostrar el formulario para crear un reporte
    public function create()
    {
        // Obtener todas las instituciones y categorías
        $institutions = Institution::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('reports.create', compact('institutions', 'categories', 'subcategories'));
    }

    // Guardar el reporte en la base de datos y generar el PDF
// Guardar el reporte en la base de datos y generar el PDF
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

        // Crear el reporte
        $report = Report::create([
            'date_time' => now(),
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

        // Generar el PDF
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

        $pdf = Pdf::loadView('pdf.view', $data);
        $pdfPath = 'pdfs/report_' . $report->id . '.pdf';
        $pdf->save(storage_path("app/public/{$pdfPath}"));

        // Guardar la ruta del PDF en el reporte
        $report->update(['pdf_path' => $pdfPath]);

        return redirect()->route('reports.pdf', ['reportId' => $report->id]);
    }

    // Función para generar el PDF
    public function generatePdf($reportId)
    {
        // Se obtiene el reporte con las relaciones
        $report = Report::with(['category', 'subcategory', 'institution'])->findOrFail($reportId);

        //Pasa datos al PDF
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

    // Mostrar un reporte específico (opcional si necesitas)
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    // Mostrar el formulario de edición de un reporte
    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $institutions = Institution::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('reports.edit', compact('report', 'institutions', 'categories', 'subcategories'));
    }

    // Actualizar un reporte existente
    public function update(Request $request, $id)
    {
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

        // Buscar el reporte y actualizar sus datos
        $report = Report::findOrFail($id);
        $report->update($request->all());

        // Actualizar el PDF con los nuevos datos
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

        $pdf = Pdf::loadView('pdf.view', $data);
        $pdfPath = 'pdfs/report_' . $report->id . '.pdf';
        $pdf->save(storage_path("app/public/{$pdfPath}"));

        $report->update(['pdf_path' => $pdfPath]);

        return redirect()->route('dashboard')->with('success', 'Reporte actualizado correctamente.');
    }
    // Eliminar un reporte (opcional si lo necesitas)
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->route('dashboard');
    }

    // Buscar reportes por número de expediente o fecha
    public function search(Request $request){
        $query = $request->input('query');

        // Filtrar reportes por número de expediente o fecha
        $reports = Report::where('expedient_number', 'LIKE', "%$query%")
            ->orWhereDate('report_date', $query)
            ->get();

        return view('dashboard', compact('reports'));
    }
}





