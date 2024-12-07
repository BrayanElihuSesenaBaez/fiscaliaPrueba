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


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('users', UserController::class);

Route::middleware(['auth', 'role:Fiscal General'])->group(function () {

    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/search', [ReportController::class, 'search'])->name('reports.search');

    Route::get('reports/{id}/pdf', [PdfController::class, 'viewPdf'])->name('reports.viewPdf');
    Route::get('/reports/{id}/download', [ReportController::class, 'download'])->name('reports.download');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}/generate-pdf', [PdfController::class, 'generatePdf'])->name('reports.generatePdf');

    Route::get('pdf/download/{report}', [ReportController::class, 'downloadPdf'])->name('pdf.download');
    Route::get('reports/{id}/pdf', [PdfController::class, 'viewPdf'])->name('reports.viewPdf');
    Route::get('/reports/{report}/download', [ReportController::class, 'downloadPdf'])->name('reports.downloadPdf');

    Route::get('/reports/{report}/view', [ReportController::class, 'viewPdf'])->name('reports.view');
    Route::get('/reports/{report}/download', [ReportController::class, 'downloadPdf'])->name('reports.download');

    Route::get('/reports/{id}/view-pdf', [ReportController::class, 'viewPdf'])->name('reports.viewPdf');
    Route::get('/reports/{id}/download-pdf', [ReportController::class, 'downloadPdf'])->name('reports.downloadPdf');
    Route::get('/reports/{id}/view', [ReportController::class, 'viewPdf'])->name('reports.viewPdf');

    Route::get('/pdf-design/preview', [PdfController::class, 'designPreview'])->name('pdf_design.preview');

    Route::post('/pdf-design/save-logo-changes', [PdfController::class, 'saveLogoChanges'])->name('pdf_design.saveLogoChanges');

    Route::get('/pdf-design', [PdfDesignController::class, 'index'])->name('pdf_design.index');
    Route::post('/pdf-design', [PdfDesignController::class, 'upload'])->name('pdfdesign.upload');
    Route::post('/pdf-design/save', [PdfDesignController::class, 'save'])->name('pdfdesign.save');
    Route::get('/pdf-design/generate', [PdfDesignController::class, 'generatePdf'])->name('pdfdesign.generate');
    Route::delete('/pdf-design/{id}', [PdfDesignController::class, 'destroy'])->name('pdf_design.destroy');
    Route::get('/pdf-design/image/{id}', [PdfDesignController::class, 'showImage'])->name('pdf_design.showImage');
    Route::get('pdfdesign/preview', [PdfDesignController::class, 'preview'])->name('pdfdesign.preview');
    Route::post('pdfdesign/update-selection', [PdfDesignController::class, 'updateSelection'])->name('pdfdesign.updateSelection');
    Route::post('/pdf-design/save', [PdfDesignController::class, 'saveDesign']);


    Route::post('/pdf-design/upload', [PdfDesignController::class, 'upload'])->name('pdfdesign.upload');
    Route::post('/pdf-design/update-selection', [PdfDesignController::class, 'updateSelection'])->name('pdf_design.updateSelection');
    Route::get('/pdf-design/preview', [PdfDesignController::class, 'preview'])->name('pdfdesign.preview');


    Route::get('/report/{id}/pdf', [ReportController::class, 'generatePdf'])->name('report.pdf');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        if (Auth::user()->hasRole('Fiscal General')) {
            return redirect()->route('dashboard');
        } else {
            return view('home');
        }
    })->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{reportId}/pdf', [PdfController::class, 'generatePdf'])->name('reports.pdf');
});


Route::get('/subcategories/{categoryId}', [SubcategoryController::class, 'getSubcategories']);
Route::get('/get-municipalities/{stateId}', [LocationController::class, 'getMunicipalities']);
Route::get('/get-zipcodes/{municipalityId}', [LocationController::class, 'getZipCodes']);
Route::get('/get-colonies/{zipCode}', [LocationController::class, 'getColonies']);
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
Route::get('/generate-pdf/{reportId}', [PdfController::class, 'generatePdf']);




