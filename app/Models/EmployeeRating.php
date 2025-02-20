<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRating extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'employee_id',
        'rating',
        'review'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
