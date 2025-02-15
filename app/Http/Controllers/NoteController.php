<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // عرض الملاحظات للعميل أو العميل المحتمل
    public function show($noteableType, $noteableId)
    {
        // تحديد النوع والـ ID الملاحظات بناءً على الـ polymorphic relationship
        $noteableClass = "App\\Models\\" . ucfirst($noteableType);
        $noteable = $noteableClass::findOrFail($noteableId);

        // جلب الملاحظات المرتبطة
        $notes = $noteable->notes;

        return view('notes.show', compact('notes', 'noteable'));
    }

    // إضافة ملاحظة جديدة
    public function store(Request $request, $noteableType, $noteableId)
    {
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        // تحديد النوع والـ ID الملاحظات بناءً على الـ polymorphic relationship
        $noteableClass = "App\\Models\\" . ucfirst($noteableType);
        $noteable = $noteableClass::findOrFail($noteableId);

        // إضافة الملاحظة
        $note = new Note([
            'note' => $request->input('note'),
            'noteable_type' => $noteableClass,
            'noteable_id' => $noteable->id,
            'employee_id' => Auth::id(), // استخدام الموظف الحالي
        ]);

        $note->save();

        return redirect()->back()->with('success', 'Note added successfully.');
    }

    // تعديل ملاحظة
public function edit($noteId)
{
    // جلب الملاحظة حسب الـ ID
    $note = Note::findOrFail($noteId);

    // التأكد من أن الملاحظة تخص الموظف الحالي
    if ($note->employee_id !== Auth::id()) {
        return redirect()->back()->with('error', 'You are not authorized to edit this note.');
    }

    return view('notes.edit', compact('note'));
}

// تحديث الملاحظة
public function update(Request $request, $noteId)
{
    $request->validate([
        'note' => 'required|string|max:255',
    ]);

    $note = Note::findOrFail($noteId);

    // التأكد من أن الملاحظة تخص الموظف الحالي
    if ($note->employee_id !== Auth::id()) {
        return redirect()->back()->with('error', 'You are not authorized to edit this note.');
    }

    $note->note = $request->input('note');
    $note->save();

    return redirect()->route('notes.show', [
        'noteableType' => class_basename($note->noteable_type),
        'noteableId' => $note->noteable_id
    ])->with('success', 'Note updated successfully.');
}

// حذف ملاحظة
public function destroy($noteId)
{
    $note = Note::findOrFail($noteId);

    // التأكد من أن الملاحظة تخص الموظف الحالي
    if ($note->employee_id !== Auth::id()) {
        return redirect()->back()->with('error', 'You are not authorized to delete this note.');
    }

    $note->delete();

    return redirect()->back()->with('success', 'Note deleted successfully.');
}

}
