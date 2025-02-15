<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['New', 'Contacted', 'Won', 'Lost']),
            'source' => $this->faker->randomElement(['Social Media', 'Website', 'Referral', 'Other']),
            'assigned_to' => Employee::factory(),
            'notes' => $this->faker->paragraph,
            'converted_at' => $this->faker->optional()->dateTime,
        ];
    }
}
