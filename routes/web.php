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
    Route::get('/pdf_design', [PdfDesignController::class, 'index'])->name('pdf_design.index');
    Route::match(['post'], '/pdf-design', [PdfDesignController::class, 'store'])->name('pdf_design.store');

    Route::delete('/pdf-design/{id}', [PdfDesignController::class, 'destroy'])->name('pdf_design.destroy');

    Route::get('/pdf-design', [PdfDesignController::class, 'index'])->name('pdf_design.index');


    // Ruta para seleccionar los logotipos y guardarlos en la sesión
    Route::post('/pdf-design/select', [PdfDesignController::class, 'selectLogos'])->name('pdf_design.selectLogos');

    // Ruta para generar la vista previa del diseño en PDF
    Route::post('/pdf-design/preview', [PdfDesignController::class, 'generateDesignPreview'])->name('pdf_design.generateDesignPreview');

    // Ruta para generar el PDF final
    Route::get('/pdf-design/generate', [PdfDesignController::class, 'generate'])->name('pdf_design.generate');
    // Ruta para finalizar el diseño y generar el PDF final
    Route::get('/pdf-design/finalize', [PdfDesignController::class, 'finalize'])->name('pdf_design.finalize');

    Route::get('/pdf/design/preview', [PdfDesignController::class, 'preview'])->name('pdf_design.preview');


    Route::get('/pdf/design/previewPdf', [PdfDesignController::class, 'previewPdf'])->name('pdf_design.previewPdf   ');
    Route::post('/pdf-design/save', [PdfDesignController::class, 'saveDesign'])->name('pdf_design.save');

    Route::post('/pdf_design/generate-preview', [PdfDesignController::class, 'generateDesignPreview'])->name('pdf_design.generateDesignPreview');

    Route::post('/pdf_design/generatePdf', [PdfDesignController::class, 'generatePdf'])->name('pdf_design.generatePdf');

    Route::post('/pdf_design/showPdfPreview', [PdfDesignController::class, 'showPdfPreview'])->name('pdf_design.showPdfPreview');

    Route::post('/pdf-design/save-logo-changes', [PdfDesignController::class, 'saveLogoChanges']);


    Route::get('/pdf/design', [PdfDesignController::class, 'index'])->name('pdf.design');

    Route::post('/pdf/design/save', [PdfDesignController::class, 'store'])->name('pdf.design.save');

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







