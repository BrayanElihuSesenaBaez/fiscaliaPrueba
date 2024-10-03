<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/reports/create', [ReportController::class, 'create']);
Route::post('/reports', [ReportController::class, 'store']);


