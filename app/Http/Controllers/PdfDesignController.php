<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\PdfLogo;
use Illuminate\Support\Facades\Storage;


class PdfDesignController extends Controller{
    public function index()
    {
        $logosDetails = PdfLogo::all();

        // Obtener los logotipos seleccionados para el encabezado y pie de página
        $selectedHeaderLogos = PdfLogo::where('location', 'header')->pluck('file_path')->toArray();
        $selectedFooterLogos = PdfLogo::where('location', 'footer')->pluck('file_path')->toArray();

        // Almacenar los seleccionados en la sesión (si es necesario para vista previa)
        session(['selected_header_logos' => $selectedHeaderLogos]);
        session(['selected_footer_logos' => $selectedFooterLogos]);

        return view('users.pdf_design', compact('logosDetails', 'selectedHeaderLogos', 'selectedFooterLogos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('logo');
        $path = $file->store('logos', 'public'); // Guarda en storage/app/public/logos

        PdfLogo::create([
            'name' => $request->input('name'),
            'file_path' => $path, // Aquí se guarda la ruta en la base de datos
            'is_active' => false,
            'location' => 'pending',
            'section' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Logo agregado exitosamente.');
    }

    public function destroy($id){
        $logo = PdfLogo::findOrFail($id);

        // Verifica si el archivo realmente existe y lo elimina
        if (Storage::exists($logo->file_path)) {
            Storage::delete($logo->file_path);
        }

        $logo->delete();

        return redirect()->back()->with('success', 'Logotipo eliminado.');
    }


    public function update(Request $request, $id){
        $logo = PdfLogo::findOrFail($id);

        $request->validate([
            'alignment' => 'required|in:left,center,right',
        ]);

        $logo->alignment = $request->input('alignment');
        $logo->save();

        return redirect()->route('pdf_design.index')->with('success', 'Logotipo actualizado correctamente.');
    }

    public function selectLogos(Request $request)
    {
        $headerLogos = $request->input('header_logos', []);
        $footerLogos = $request->input('footer_logos', []);

        // Actualiza 'location' y 'section' para los logos seleccionados
        PdfLogo::whereIn('file_path', $headerLogos)->update([
            'location' => 'header',
            'section' => 'header',
        ]);

        PdfLogo::whereIn('file_path', $footerLogos)->update([
            'location' => 'footer',
            'section' => 'footer',
        ]);

        // Actualizar la sesión
        session(['selected_header_logos' => $headerLogos]);
        session(['selected_footer_logos' => $footerLogos]);

        return redirect()->route('pdf_design.index')->with('success', 'Logotipos seleccionados correctamente.');
    }

    public function preview(){
        // Recupera los logotipos seleccionados para el encabezado y pie de página
        $logosDetails = PdfLogo::whereIn('location', ['header', 'footer'])->get();

        return view('users.pdf_design_preview', compact('logosDetails'));
    }

    public function finalize(){
        $logosDetails = PdfLogo::whereIn('location', ['header', 'footer'])->get();

        if ($logosDetails->isEmpty()) {
            return redirect()->route('pdf_design.index')->with('error', 'No se han seleccionado logotipos.');
        }

        foreach ($logosDetails as $logo) {
            $logo->full_path = storage_path('app/public/' . $logo->file_path);
        }

        $pdf = Pdf::loadView('pdf.view', compact('logosDetails'));

        return $pdf->download('final_design.pdf');
    }


    public function generateDesignPreview(Request $request){
        $selectedHeaderLogos = session('selected_header_logos', []);
        $selectedFooterLogos = session('selected_footer_logos', []);

        if (empty($selectedHeaderLogos) && empty($selectedFooterLogos)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se han seleccionado logotipos para la vista previa.'
            ]);
        }

        $logosDetails = PdfLogo::whereIn('file_path', array_merge($selectedHeaderLogos, $selectedFooterLogos))->get();

        return view('users.pdf_design_preview', compact('logosDetails'));
    }


    public function previewPdf(Request $request){
        $logos = $request->input('logos');

        if (!$logos || empty($logos)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se enviaron logotipos.'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Logotipos recibidos correctamente.',
            'logos' => $logos
        ]);
    }

    public function saveLogoChanges(Request $request)
    {
        $logos = $request->input('logos');

        foreach ($logos as $logoData) {
            $logo = PdfLogo::findOrFail($logoData['id']);

            if ($logo) {
                $logo->position_x = $logoData['position_x'];
                $logo->position_y = $logoData['position_y'];
                $logo->width = $logoData['width'];
                $logo->height = $logoData['height'];
                $logo->save();
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Logotipos actualizados correctamente.']);
    }


    public function showPdfPreview(){
        $logos = PdfLogo::all();

        return view('pdf_preview', compact('logos'));
    }
}




