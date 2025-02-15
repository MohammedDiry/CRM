<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware(['auth'])->group(function () {
    // عرض الملاحظات
    Route::get('/{noteableType}/{noteableId}/notes', [NoteController::class, 'show'])->name('notes.show');

    // إضافة ملاحظة
    Route::post('/{noteableType}/{noteableId}/notes', [NoteController::class, 'store'])->name('notes.store');

    // تعديل ملاحظة
    Route::get('/notes/{noteId}/edit', [NoteController::class, 'edit'])->name('notes.edit');

    // تحديث ملاحظة
    Route::put('/notes/{noteId}', [NoteController::class, 'update'])->name('notes.update');

    // حذف ملاحظة
    Route::delete('/notes/{noteId}', [NoteController::class, 'destroy'])->name('notes.destroy');
});
