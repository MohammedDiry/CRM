<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;


// راوت لحذف المصروف مع Middleware منفصل
Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->middleware('check.admin.or.user.admin')->name('expenses.destroy');
// تعريف Resource للمصاريف
Route::resource('expenses', ExpenseController::class)->middleware('check.accountant.or.user.admin');
