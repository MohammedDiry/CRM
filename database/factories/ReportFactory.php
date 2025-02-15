<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        return [
            'report_type' => $this->faker->randomElement(['Financial', 'Project Summary', 'Performance']),
            'generated_by' => Employee::factory(),
            'data' => $this->faker->paragraph,
        ];
    }
}
