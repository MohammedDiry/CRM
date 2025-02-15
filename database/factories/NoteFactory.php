<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Note;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Employee;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        // اختيار ما إذا كانت الملاحظة تخص Client أو Lead
        $noteableType = $this->faker->randomElement([Client::class, Lead::class]);

        // جلب ID عشوائي أو إنشاء سجل جديد إذا لم يكن هناك بيانات
        $noteableId = $noteableType::inRandomOrder()->value('id') ?? $noteableType::factory()->create()->id;

        // جلب ID لموظف عشوائي أو إنشاء موظف جديد إذا لم يوجد
        $employeeId = Employee::inRandomOrder()->value('id') ?? Employee::factory()->create()->id;

        return [
            'note' => $this->faker->sentence(10), // جملة عشوائية
            'noteable_id' => $noteableId,
            'noteable_type' => $noteableType,
            'employee_id' => $employeeId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
