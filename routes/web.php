<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('dash', [DashboardController::class, 'index'])->name('index');








Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/clients.php'; // لملف الـ Clients
require __DIR__ . '/leads.php'; // لملف الـ Leads
require __DIR__ . '/projects.php'; // لملف الـ Projects
require __DIR__ . '/expenses.php'; // لملف الـ Expenses
require __DIR__ . '/employees.php'; // لملف الـ Employees
require __DIR__ . '/reports.php'; // لملف الـ Reports
require __DIR__ . '/project_team.php'; // لملف الـ Project Team
require __DIR__ . '/employee_ratings.php'; // لملف الـ Employee Ratings
require __DIR__ . '/invoices.php'; // لملف الـ Invoices
require __DIR__ . '/notes.php'; // لملف الـ note
