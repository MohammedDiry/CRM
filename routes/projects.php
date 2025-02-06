<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::resource('projects', ProjectController::class);
Route::post('projects/{project}/assign-team', [ProjectController::class, 'assignTeam'])->name('projects.assign-team');
