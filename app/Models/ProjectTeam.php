<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    use HasFactory;

    protected $table = 'project_team';

    protected $fillable = [
        'project_id',
        'employee_id',
        'team_lead_id',
        'assigned_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function teamLead()
    {
        return $this->belongsTo(Employee::class, 'team_lead_id');
    }
}
