<?php

namespace Database\Factories;

use App\Models\EmployeeRating;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeRatingFactory extends Factory
{
    protected $model = EmployeeRating::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'employee_id' => Employee::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->paragraph,
        ];
    }
}
