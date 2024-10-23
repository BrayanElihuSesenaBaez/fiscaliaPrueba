<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\HomeController;

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
Route::middleware(['auth', 'role:Fiscal General'])->group(function () {
        // Muestra una pantalla de inicio para el Fiscal General
        Route::get('/dashboard', function () {
            return view('dashboard');//Se manda a una vista llamada "dashboard.blade.php" siendo la pantalla de inicio del usuario con rol "Fiscal General"
        })->name('dashboard');

        // Pantalla de inicio para el Fiscal General
        Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

        // Ruta de una lista de los usuarios existentes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // Ruta para crear un nuevo usuario
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

        // Ruta para almacenar un nuevo usuario
        Route::post('/users', [UserController::class, 'store'])->name('users.store');

        // Ruta para mostrar el formulario para editar de un usuario existente
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

        // Ruta para actualizar un usuario existente
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

        // Ruta para eliminar un usuario
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Página de creación de reportes
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');

        // Ruta para buscar reportes
         Route::get('/reports/search', [ReportController::class, 'search'])->name('reports.search');

        // Rutas para ver, editar, actualizar y eliminar reportes
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
        Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/search', [ReportController::class, 'search'])->name('reports.search');


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


//Route::get('/', function () {
//    return view('welcome');
//})->name('welcome');

// Rutas de las subcategorías de acuerdo a su categoria
Route::get('/subcategories/{categoryId}', [SubcategoryController::class, 'getSubcategories']);

// Generación de PDF
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);






