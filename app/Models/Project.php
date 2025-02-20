<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'budget',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function team()
    {
        return $this->belongsToMany(Employee::class, 'project_team', 'project_id', 'employee_id')->withPivot('assigned_date', 'team_lead_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function employeeRatings()
    {
        return $this->hasMany(EmployeeRating::class);
    }


    public function projectTeam()
    {
        return $this->hasMany(ProjectTeam::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'project_id'); // علاقة اختيارية بالتقارير
    }
}
