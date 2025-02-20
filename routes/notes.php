<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware(['check.csr.or.accountant.or.user.admin'])->group(function () {
    // إضافة روت للانتقال إلى صفحة إنشاء ملاحظة
    Route::get('{noteableType}/{noteableId}/notes/create', [NoteController::class, 'create'])->name('notes.create');
    // عرض الملاحظات
    Route::get('/{noteableType}/{noteableId}/notes', [NoteController::class, 'show'])->name('notes.show');

    // إضافة ملاحظة
    Route::post('notes/store', [NoteController::class, 'store'])->name('notes.store');
    // تعديل ملاحظة
    Route::get('notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');

    // تحديث ملاحظة
    Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
});

Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy')->middleware('check.admin.or.user.admin');
