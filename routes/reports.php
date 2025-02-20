<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::delete('reports/{reports}', [ReportController::class, 'destroy'])->name('reports.destroy')->middleware('check.admin.or.user.admin');



Route::resource('reports', ReportController::class)->except(['destroy'])->middleware('auth');;
