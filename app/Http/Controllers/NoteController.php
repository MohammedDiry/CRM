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

    public function create($noteableType, $noteableId)
    {
        // التحقق من النوع الصحيح وإحضار البيانات
        if ($noteableType === 'clients') {
            $noteable = Client::findOrFail($noteableId);
        } elseif ($noteableType === 'leads') {
            $noteable = Lead::findOrFail($noteableId);
        } else {
            abort(404); // إذا كان النوع غير معروف
        }

        return view('notes.create', [
            'noteableType' => $noteableType,
            'noteableId' => $noteableId,
            'noteable' => $noteable
        ]);
    }


    // إضافة ملاحظة جديدة
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'note' => 'required|string',
            'noteableType' => 'required|in:clients,leads',
            'noteableId' => 'required|integer',
        ]);

        // التأكد من صحة الكائن
        if ($validatedData['noteableType'] === 'clients') {
            $noteable = Client::findOrFail($validatedData['noteableId']);
        } elseif ($validatedData['noteableType'] === 'leads') {
            $noteable = Lead::findOrFail($validatedData['noteableId']);
        } else {
            abort(404);
        }

        // إنشاء الملاحظة
        $note = new Note();
        $note->note = $validatedData['note'];
        $note->employee_id = auth()->user()->employee->id; // الموظف الحالي
        $note->noteable()->associate($noteable); // ربط الملاحظة بالكائن (Client أو Lead)
        $note->save();

        return redirect()->route($validatedData['noteableType'] . '.show', $validatedData['noteableId'])
            ->with('success', 'Note added successfully.');
    }



    // تعديل ملاحظة
    public function edit(Note $note)
    {
        // السماح فقط لصاحب الملاحظة أو المشرف (Admin)
        if (auth()->user()->employee->id !== $note->employee_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    // تحديث الملاحظة
    public function update(Request $request, Note $note)
    {
        // التحقق من الصلاحيات
        if (auth()->user()->employee->id !== $note->employee_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'note' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->back()->with('success', 'Note updated successfully.');
    }


    // حذف ملاحظة
    public function destroy(Note $note)
    {
        // السماح فقط لصاحب الملاحظة أو المشرف (Admin)
        if (auth()->user()->employee->id !== $note->employee_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully.');
    }
}
