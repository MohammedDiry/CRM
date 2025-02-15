<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        // اختيار عميل عشوائي من الجدول، وإذا لم يوجد أي عميل يتم إنشاؤه
        $client = Client::inRandomOrder()->first() ?? Client::factory()->create();

        $startDate = $this->faker->dateTimeBetween('-6 months', 'now'); // تاريخ بدء حديث
        $endDate = $this->faker->optional(0.7)->dateTimeBetween($startDate, '+6 months'); // 70% احتمال لتحديد تاريخ نهاية

        return [
            'client_id' => $client->id, // استخدام عميل حقيقي من الجدول
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'budget' => $this->faker->randomFloat(2, 1000, 10000),
            'status' => $this->faker->randomElement(['Ongoing', 'Completed', 'On Hold']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

