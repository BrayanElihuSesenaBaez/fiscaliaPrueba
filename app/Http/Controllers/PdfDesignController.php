<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\PdfLogo;
use Illuminate\Support\Facades\Storage;
use App\Models\PdfDesign;
use Intervention\Image\Facades\Image;

class PdfDesignController extends Controller{

    public function index()
    {
        // Obtener los logos almacenados en la base de datos
        $logos = PdfLogo::all();
        // Retornar la vista con los datos
        return view('users.pdf_design', compact('logos'));
    }


    // Código del controlador para guardar el logo
    public function upload(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Obtener la imagen original
        $image = $request->file('logo');

        // Redimensionar la imagen a un tamaño fijo (por ejemplo, 300px de ancho)
        $imageResized = Image::make($image)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio(); // Mantener la relación de aspecto
            $constraint->upsize(); // Evitar que la imagen se agrande si es pequeña
        });

        // Convertir la imagen redimensionada a datos binarios
        $imageData = $imageResized->encode(); // Codificar la imagen como binario

        // Guardar la imagen redimensionada en la base de datos
        $logo = PdfLogo::create([
            'name' => $image->getClientOriginalName(),
            'image_data' => $imageData, // Guardar la imagen como binario
        ]);

        return back()->with('success', 'Logo subido exitosamente');
    }

    public function showImage($id)
    {
        $logo = PdfLogo::findOrFail($id);

        // Detectar dinámicamente el tipo MIME desde los datos binarios
        $mimeType = $this->getMimeTypeFromBinary($logo->image_data);

        // Crear una respuesta con los datos binarios y el tipo MIME
        return response($logo->image_data, 200)
            ->header('Content-Type', $mimeType);
    }


    // Metodo para obtener el tipo MIME según la extensión del archivo
    public function getMimeTypeFromBinary($imageData)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($imageData);
        return $mimeType;
    }




    public function save(Request $request)
    {
        // Guardar los logos y sus posiciones en la base de datos
        // Asumiendo que ya estás procesando los logos

        // Actualizar los logos en la base de datos
        foreach ($request->logos as $logoData) {
            $logo = PdfLogo::find($logoData['id']);
            if ($logo) {
                $logo->update([
                    'position_x' => $logoData['position_x'],
                    'position_y' => $logoData['position_y'],
                    'width' => $logoData['width'],
                    'height' => $logoData['height'],
                ]);
            }
        }

        return response()->json(['success' => 'Los cambios han sido guardados exitosamente.']);
    }

    public function destroy($id)
    {
        // Buscar el logo por ID
        $logo = PdfLogo::findOrFail($id);

        // Verificar si file_path tiene un valor antes de intentar eliminar el archivo
        if ($logo->file_path && Storage::disk('public')->exists($logo->file_path)) {
            // Eliminar el archivo físico del almacenamiento
            Storage::disk('public')->delete($logo->file_path);
        }

        // Eliminar el registro de la base de datos
        $logo->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('pdf_design.index')->with('success', 'Logo eliminado exitosamente.');
    }

    public function updateSelection(Request $request)
    {
        $request->validate([
            'header_logos' => 'array|nullable',
            'footer_logos' => 'array|nullable',
        ]);

        // Asegúrate de que los datos se reciban correctamente
        $headerLogos = $request->input('header_logos', []);
        $footerLogos = $request->input('footer_logos', []);

        // Suponiendo que se va a guardar el diseño PDF con los logos seleccionados
        $pdfDesign = PdfDesign::first();
        if ($pdfDesign) {
            $pdfDesign->update([
                'header_logos' => $headerLogos,
                'footer_logos' => $footerLogos,
            ]);
        }

        return redirect()->route('pdfdesign.preview')
            ->with('success', 'Selección guardada exitosamente');
    }


    public function preview()
    {
        $pdfDesign = PdfDesign::first(); // Obtener el primer diseño PDF de la base de datos
        $logos = PdfLogo::whereIn('id', array_merge($pdfDesign->header_logos ?? [], $pdfDesign->footer_logos ?? []))->get();
        return view('users.pdf_design_preview', compact('pdfDesign', 'logos'));
    }
}




