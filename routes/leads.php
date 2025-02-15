<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;



Route::resource('leads', LeadController::class);
Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');
