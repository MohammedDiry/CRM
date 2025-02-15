<?php

namespace Database\Factories;

use App\Models\ProjectTeam;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTeamFactory extends Factory
{
    protected $model = ProjectTeam::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'employee_id' => Employee::factory(),
            'team_lead_id' => Employee::factory(),
            'assigned_date' => now(),
        ];
    }
}
