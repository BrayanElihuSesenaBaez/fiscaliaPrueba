<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Subcategory;

class ReportController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('reports.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        // Validar los datos enviados desde el formulario
        $validatedData = $request->validate([
            'description' => 'required|string',
            'report_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Crear el reporte
        $report = Report::create($validatedData);

        return redirect()->back()->with('success', 'Reporte creado exitosamente.');
    }
}

