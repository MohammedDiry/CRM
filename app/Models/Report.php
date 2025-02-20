<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'generated_by',
        'data',
        'project_id'
    ];

    public function generatedBy()
    {
        return $this->belongsTo(Employee::class, 'generated_by');
    }


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id'); // علاقة اختيارية بمشروع
    }
}
