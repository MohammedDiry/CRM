<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show')->middleware('check.csr.or.accountant.or.user.admin'); // مدلوير عرض التفاصيل

Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy')->middleware('check.admin.or.user.admin'); // مدلوير الحذف

Route::group(['middleware' => 'check.accountant.or.user.admin'], function () {
    Route::get('/invoices/create/{projectId}', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::resource('invoices', InvoiceController::class)->except(['create','destroy', 'show']);
});


