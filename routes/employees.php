<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


// عرض جميع الموظفين
Route::get('employees', [EmployeeController::class, 'index'])->middleware('check.accountant.or.user.admin')->name('employees.index');

// حذف الموظف
Route::delete('employees/{employees}', [EmployeeController::class, 'destroy'])->middleware('check.admin.or.user.admin')->name('employees.destroy');

// مجموعة الراوتات الخاصة بإنشاء الموظف
Route::middleware('check.admin.or.user.admin')->group(function () {
    // صفحة إنشاء الموظف
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

    // حفظ الموظف الجديد
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

    // تعيين الدور للموظف
    Route::post('employees/{employee}/assign-role', [EmployeeController::class, 'assignRole'])->name('employees.assign-role');
});

// تعريف راوت resource بعد الراوتات المخصصة
Route::resource('employees', EmployeeController::class)->except(['store', 'create', 'index', 'destroy'])->middleware('auth');
