<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\PdfLogo;
use Illuminate\Support\Facades\Storage;
use App\Models\PdfDesign;


class PdfDesignController extends Controller{

    public function index(){
        $logos = PdfLogo::all();
        // Retornar la vista con los datos
        return view('users.pdf_design', compact('logos'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $image = $request->file('logo');

        $originalImage = imagecreatefromstring(file_get_contents($image));
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        $maxWidth = 100;
        $maxHeight = 75;

        $aspectRatio = $originalWidth / $originalHeight;
        if ($aspectRatio > 1) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $aspectRatio;
        } else {
            $newWidth = $maxHeight * $aspectRatio;
            $newHeight = $maxHeight;
        }

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($image->getClientOriginalExtension() === 'png') {
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }

        imagecopyresampled(
            $resizedImage,
            $originalImage,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            $originalWidth, $originalHeight
        );

        ob_start();
        imagepng($resizedImage);
        $imageData = ob_get_clean();

        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        PdfLogo::create([
            'name' => $image->getClientOriginalName(),
            'image_data' => $imageData,
            'mime_type' => 'image/png',
        ]);

        return redirect()->route('pdf_design.index')->with('success', 'Logo subido exitosamente');
    }




    public function showImage($id)
    {
        $logo = PdfLogo::findOrFail($id);

        $image = imagecreatefromstring($logo->image_data);
        $newWidth = 100;
        $newHeight = 75;

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($logo->mime_type === 'image/png') {
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefill($resizedImage, 0, 0, $transparent);
        }

        imagecopyresampled(
            $resizedImage,
            $image,
            0, 0, 0, 0,
            $newWidth, $newHeight,
            imagesx($image),
            imagesy($image)
        );

        ob_start();
        if ($logo->mime_type === 'image/png') {
            imagepng($resizedImage);
        } else {
            imagejpeg($resizedImage);
        }
        $imageData = ob_get_clean();

        imagedestroy($image);
        imagedestroy($resizedImage);

        return response($imageData, 200)
            ->header('Content-Type', $logo->mime_type);
    }


    public function getMimeTypeFromBinary($imageData){
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($imageData) ?: null;
    }

    public function save(Request $request)
    {
        $headerLimit = [
            'top' => 0,
            'bottom' => 113,
            'left' => 0,
            'right' => 794,
        ];

        $footerLimit = [
            'top' => 1048,
            'bottom' => 1123,
            'left' => 0,
            'right' => 794,
        ];

        foreach ($request->logos as $logoData) {
            $logo = PdfLogo::find($logoData['id']);
            if ($logo) {
                $x = $logoData['position_x'];
                $y = $logoData['position_y'];

                if ($logoData['section'] === 'header') {
                    $y = max($headerLimit['top'], min($y, $headerLimit['bottom'] - $logoData['height']));
                } elseif ($logoData['section'] === 'footer') {
                    $y = max($footerLimit['top'], min($y, $footerLimit['bottom'] - $logoData['height']));
                }

                $logo->update([
                    'position_x' => $x,
                    'position_y' => $y,
                    'width' => $logoData['width'],
                    'height' => $logoData['height'],
                    'section' => $logoData['section'],
                ]);
            }
        }
            if (isset($request->header_logos) || isset($request->footer_logos)) {
                $pdfDesign = PdfDesign::firstOrCreate(['id' => 1]);
                $pdfDesign->header_logos = $request->input('header_logos', []);
                $pdfDesign->footer_logos = $request->input('footer_logos', []);
                $pdfDesign->save();
            }

            return response()->json(['success' => 'Los cambios han sido guardados exitosamente.']);
    }

    public function destroy($id)
    {
        $logo = PdfLogo::findOrFail($id);

        if ($logo->file_path && Storage::disk('public')->exists($logo->file_path)) {
            Storage::disk('public')->delete($logo->file_path);
        }

        $logo->delete();

        return redirect()->route('pdf_design.index')->with('success', 'Logo eliminado exitosamente.');
    }

    public function updateSelection(Request $request)
    {
        $validated = $request->validate([
            'header_logos' => 'nullable|array',
            'footer_logos' => 'nullable|array',
            'header_logos.*' => 'exists:pdf_logos,id',
            'footer_logos.*' => 'exists:pdf_logos,id',
        ]);

        $pdfDesign = PdfDesign::firstOrCreate([
            'id' => 1,
        ]);

        $pdfDesign->header_logos = $request->input('header_logos', []);
        $pdfDesign->footer_logos = $request->input('footer_logos', []);
        $pdfDesign->save();

        if ($request->has('header_logos')) {
            foreach ($request->input('header_logos') as $logoId) {
                $logo = PdfLogo::find($logoId);
                if ($logo) {
                    $logo->location = 'encabezado';
                    $logo->section = 'header';
                    $logo->save();
                }
            }
        }

        if ($request->has('footer_logos')) {
            foreach ($request->input('footer_logos') as $logoId) {
                $logo = PdfLogo::find($logoId);
                if ($logo) {
                    $logo->location = 'pie de página';
                    $logo->section = 'footer';
                    $logo->save();
                }
            }
        }
        return redirect()->route('pdfdesign.preview')->with('success', 'Selección guardada exitosamente');
    }

    public function preview()
    {
        $pdfDesign = PdfDesign::first();
        $logos = PdfLogo::whereIn('id', array_merge($pdfDesign->header_logos ?? [], $pdfDesign->footer_logos ?? []))->get();
        return view('users.pdf_design_preview', compact('pdfDesign', 'logos'));
    }

    public function saveDesign(Request $request)
    {
        foreach ($request->logos as $logoData) {
            $logo = PdfLogo::find($logoData['id']);
            if ($logo) {
                $logo->position_x = $logoData['position_x'];
                $logo->position_y = $logoData['position_y'];
                $logo->width = $logoData['width'];
                $logo->height = $logoData['height'];
                $logo->save();
            }
        }

        return response()->json(['success' => 'Cambios guardados correctamente.']);
    }
}




