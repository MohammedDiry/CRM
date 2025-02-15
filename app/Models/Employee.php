<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'role', 'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }
}
