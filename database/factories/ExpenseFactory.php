<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'category' => $this->faker->randomElement(['Advertising', 'Software', 'Salaries', 'Miscellaneous']),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'description' => $this->faker->sentence,
            'date' => $this->faker->date,
        ];
    }
}
