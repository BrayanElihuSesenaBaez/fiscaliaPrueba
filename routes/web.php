<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\MessageController;


Route::view('/', 'home')->name('home');
Route::view('/quienes-somos', 'about')->name('about');

Route::get('/portafolio', [ProjectController::class, 'index' ])->name('projects.index');
Route::get('/portafolio/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::view('/contacto', 'contact')->name('contact');


Route::post('/contacto', [MessageController::class, 'store'])->name('messages.store');

