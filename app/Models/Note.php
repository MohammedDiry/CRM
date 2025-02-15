<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['note', 'noteable_id', 'noteable_type', 'employee_id'];

    // العلاقة مع الكائن الذي تخصه الملاحظة (إما عميل أو عميل محتمل)
    public function noteable()
    {
        return $this->morphTo();
    }

    // العلاقة مع الموظف الذي أضاف الملاحظة
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
