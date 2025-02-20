<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->middleware('check.admin.or.user.admin')->name('leads.destroy');

Route::middleware(['check.csr.or.user.admin'])
    ->group(function () {
        Route::resource('leads', LeadController::class)->except(['destroy']);
        Route::post('leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');
    });
