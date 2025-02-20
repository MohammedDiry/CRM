<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // إنشاء موظف واحد
        $employee = Employee::create([
            'name' => 'Mohammed Diry', // يمكنك تخصيص الاسم
            'email' => 'mohammedDiry@example.com', // يمكنك تخصيص البريد الإلكتروني
            'phone' => '1234567890', // يمكنك تخصيص رقم الهاتف
            'role' => 'Admin', // يمكنك تخصيص الدور
            'password' => Hash::make('password'), // تعيين كلمة المرور
        ]);

        // إنشاء المستخدم المرتبط بالموظف
        User::create([
            'employee_id' => $employee->id, // ربط المستخدم بالموظف
            'email' => $employee->email,
            'role' => 'Admin', // يمكنك تخصيص الدور
            'password' => Hash::make('password'), // تعيين كلمة المرور للمستخدم
        ]);
    }
}
