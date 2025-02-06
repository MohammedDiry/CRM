<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectTeamController;

Route::resource('project-team', ProjectTeamController::class);
Route::post('project-team/{projectTeam}/assign-lead', [ProjectTeamController::class, 'assignLead'])->name('project-team.assign-lead');
