<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;



Route::group(['middleware' => 'check.csr.or.accountant.or.user.admin'], function () {
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
});

Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy')->middleware('check.admin.or.user.admin');

Route::resource('clients', ClientController::class)->middleware('check.csr.or.user.admin')->except(['index', 'show', 'destroy']);
