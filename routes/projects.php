<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

// مجموعة راوتات المشاريع
Route::group(['middleware' => 'auth'], function () {
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});

// مجموعة راوتات التعديل والإضافة
Route::group(['middleware' => 'check.admin.or.user.admin'], function () {
    Route::resource('projects', ProjectController::class)->except(['index', 'show']);
    Route::post('projects/{project}/assign-team', [ProjectController::class, 'assignTeam'])->name('projects.assign-team')
        ->middleware('checkProjectEditPermission');
});
