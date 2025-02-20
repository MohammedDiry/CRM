<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'address',
        'added_by'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Project::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
