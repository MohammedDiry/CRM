<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::resource('reports', ReportController::class);
Route::get('reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
