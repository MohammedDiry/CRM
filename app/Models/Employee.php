<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password'
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
        return $this->belongsToMany(Project::class, 'project_team')->withPivot('assigned_date', 'team_lead_id');;
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }

    public function employeeRatings()
    {
        return $this->hasMany(EmployeeRating::class);
    }

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'added_by');
    }

    public function assignedClient()
    {
        return $this->hasMany(Client::class, 'assigned_to');
    }
}
