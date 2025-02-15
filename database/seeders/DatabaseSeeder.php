<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\EmployeeRating;
use App\Models\Expense;
use App\Models\Project;
use App\Models\ProjectTeam;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        User::class,
        Project::class,
        EmployeeSeeder::class,
        LeadSeeder::class,
        ClientSeeder::class,
        Expense::class,
        ProjectTeam::class,
        EmployeeRating::class,
        InvoiceSeeder::class, // تشغيل فواتير بعد العملاء والمشاريع
        NoteSeeder::class,    // تشغيل الملاحظات بعد الموظفين
    ]);
    }
}
