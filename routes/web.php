<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PdfDesignController;

// Muestra la ruta al formulario de incio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Ruta para manejar el inicio de sesión
Route::post('/login', [LoginController::class, 'login']);
// Ruta para manejar el cierre de sesión
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
// Ruta que muestra una pagina de inicio dependiendo el rol determinado
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('users', UserController::class);

// Rutas protegidas por el middleware de autenticación y el rol "Fiscal General"
//Simplificacion de code
Route::middleware(['auth', 'role:Fiscal General'])->group(function () {

    // Página de inicio para el "Fiscal General"
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

    // Rutas de usuarios usando el controlador UserController
    Route::resource('users', UserController::class);

    // Rutas para reportes, solo accesibles por "Fiscal General"
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/search', [ReportController::class, 'search'])->name('reports.search');

    // Ruta para la vista previa del diseño de logotipos en PDF
    Route::get('/pdf-design/preview', [PdfController::class, 'designPreview'])->name('pdf_design.preview');

    // Ruta para guardar los cambios de los logotipos
    Route::post('/pdf-design/save-logo-changes', [PdfController::class, 'saveLogoChanges'])->name('pdf_design.saveLogoChanges');


    // Conf del logo PDF
    Route::get('/pdf-design', [PdfDesignController::class, 'index'])->name('pdf_design.index');
    Route::post('/pdf-design', [PdfDesignController::class, 'upload'])->name('pdfdesign.upload');
    Route::post('/pdf-design/save', [PdfDesignController::class, 'save'])->name('pdfdesign.save');
    Route::get('/pdf-design/generate', [PdfDesignController::class, 'generatePdf'])->name('pdfdesign.generate');
    Route::delete('/pdf-design/{id}', [PdfDesignController::class, 'destroy'])->name('pdf_design.destroy');
    Route::get('/pdf-design/image/{id}', [PdfDesignController::class, 'showImage'])->name('pdf_design.showImage');
    Route::get('pdfdesign/preview', [PdfDesignController::class, 'preview'])->name('pdfdesign.preview');
    Route::post('/pdfdesign/update-selection', [PdfDesignController::class, 'updateSelection'])->name('pdfdesign.updateSelection');

    // Ruta para seleccionar los logotipos y guardarlos en la sesión

    Route::get('/report/{id}/pdf', [ReportController::class, 'generatePdf'])->name('report.pdf');

});

// Rutas protegidas por el middleware de autenticación para los demas roles (excepto 'Fiscal General')
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        // Redirige a una pagina de inicio según el rol del usuario
        if (Auth::user()->hasRole('Fiscal General')) {
            return redirect()->route('dashboard'); // Para el Fiscal General
        } else {
            return view('home'); // Pagina de inicio para otros roles
        }
    })->name('home'); // Pagina de inicio para otros roles
    Route::get('/home', [HomeController::class, 'index'])->name('home');  // Se usa el controlador para decidir la vista
    // Muestra la página de creación de reportes y demas reportes dependiendo del rol asignado
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create'); //
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{reportId}/pdf', [PdfController::class, 'generatePdf'])->name('reports.pdf');
});


// Rutas de las subcategorías de acuerdo a su categoria
Route::get('/subcategories/{categoryId}', [SubcategoryController::class, 'getSubcategories']);

//Rutas de los Estados y Municipios de México
Route::get('/get-municipalities/{stateId}', [LocationController::class, 'getMunicipalities']);

//Rutas de Codigo Postal, Colonias y Localidades
Route::get('/get-zipcodes/{municipalityId}', [LocationController::class, 'getZipCodes']);
Route::get('/get-colonies/{zipCode}', [LocationController::class, 'getColonies']);

// Generación de PDF
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
Route::get('/generate-pdf/{reportId}', [PdfController::class, 'generatePdf']);



Route::get('/test-image', function () {
    $img = Image::canvas(300, 200, '#ff0000'); // Imagen roja de 300x200
    $img->save(public_path('test_image.jpg'));
    return 'Imagen creada: public/test_image.jpg';
});




