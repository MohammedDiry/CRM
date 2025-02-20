<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeRatingController;

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/employee_ratings/create/{project}/{employee}', [EmployeeRatingController::class, 'create'])->name('employee_ratings.create');
        Route::post('/employee_ratings/store', [EmployeeRatingController::class, 'store'])->name('employee_ratings.store');
        Route::get('/employee-ratings/edit/{rating}', [EmployeeRatingController::class, 'edit'])->name('employee_ratings.edit');
        Route::put('employee-ratings/{rating}', [EmployeeRatingController::class, 'update'])->name('employee_ratings.update');
    });

// Route::resource('employee-ratings', EmployeeRatingController::class);
