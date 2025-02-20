<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectTeamController;

Route::middleware(['check.admin.or.user.admin'])
    ->group(function () {
        Route::get('projects/{projectId}/teams/create', [ProjectTeamController::class, 'create'])->name('project-teams.create');
        Route::post('/projects/{projectId}/team', [ProjectTeamController::class, 'store'])->name('project-teams.store');
        Route::get('projects/{project}/teams/{team}/edit', [ProjectTeamController::class, 'edit'])->name('project-teams.edit');
        Route::put('projects/{project}/teams/{team}', [ProjectTeamController::class, 'update'])->name('project-teams.update');
    });

Route::get('projects/{project}/teams/{team}', [ProjectTeamController::class, 'show'])->name('project-teams.show')->middleware('auth');
