<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);
Route::post('users/{user}/assign-employee', [UserController::class, 'assignEmployee'])->name('users.assign-employee');
