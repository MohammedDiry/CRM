<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::resource('employees', EmployeeController::class);
Route::post('employees/{employee}/assign-role', [EmployeeController::class, 'assignRole'])->name('employees.assign-role');
