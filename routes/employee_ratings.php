<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeRatingController;

Route::resource('employee-ratings', EmployeeRatingController::class);
