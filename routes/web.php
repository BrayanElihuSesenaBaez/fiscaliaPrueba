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


// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Ruta para manejar el inicio de sesión
Route::post('/login', [LoginController::class, 'login']);
// Ruta para manejar el cierre de sesión
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('users', UserController::class);

// Rutas protegidas por el middleware de autenticación y el rol 'Fiscal General'
Route::middleware(['auth', 'role:Fiscal General'])->group(function () {
        // Pantalla de inicio para el Fiscal General
        Route::get('/dashboard', function () {
            return view('dashboard');  // Crear una vista llamada 'dashboard.blade.php'
        })->name('dashboard');

        // Lista de usuarios
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // Ruta para crear un nuevo usuario
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

        // Ruta para almacenar un nuevo usuario
        Route::post('/users', [UserController::class, 'store'])->name('users.store');

        // Ruta para mostrar el formulario de edición de un usuario existente
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

        // Ruta para actualizar un usuario existente
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

        // Ruta para eliminar un usuario
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Página de creación de reportes
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');

});

// Rutas protegidas por el middleware de autenticación para otros roles (excepto 'Fiscal General')
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        // Redirige según el rol del usuario
        if (Auth::user()->hasRole('Fiscal General')) {
            return redirect()->route('dashboard'); // Para el Fiscal General
        } else {
            return view('home'); // Para otros roles
        }
    })->name('home'); // Asegúrate de que la ruta esté nombrada correctamente
    Route::get('/home', [HomeController::class, 'index'])->name('home');  // Usaremos el controlador para decidir la vista
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{reportId}/pdf', [PdfController::class, 'generatePdf'])->name('reports.pdf');
});


// Ruta principal de la aplicación
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de subcategorías
Route::get('/subcategories/{categoryId}', [SubcategoryController::class, 'getSubcategories']);

/////////////////////////////////////////////

// Rutas generales de reports
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('reports/{reportId}/pdf', [PdfController::class, 'generatePdf'])->name('reports.pdf');

// Generación de PDF
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);

// Rutas de subcategorías
Route::get('/subcategories/{categoryId}', [SubcategoryController::class, 'getSubcategories']);





