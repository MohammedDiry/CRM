<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */

 class InvoiceFactory extends Factory
 {
     public function definition(): array
     {
         // جلب مشروع عشوائي مرتبط بعميل، أو إنشاء مشروع جديد
         $project = Project::has('client')->inRandomOrder()->first() ?? Project::factory()->create([
             'client_id' => Client::factory()->create()->id
         ]);

         // تحديد حالة الفاتورة
         $status = $this->faker->randomElement(['Pending', 'Paid', 'Overdue']);

         // تحديد المبالغ بناءً على حالة الفاتورة
         $totalAmount = $this->faker->numberBetween(1000, 10000);
         $amountPaid = $status === 'Paid' ? $totalAmount : null;
         $paymentDate = $status === 'Paid' ? now() : null;

         return [
             'project_id' => $project->id, // ربط الفاتورة بالمشروع
             'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(1000, 9999),
             'total_amount' => $totalAmount,
             'status' => $status,
             'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
             'amount_paid' => $amountPaid,
             'payment_date' => $paymentDate,
             'notes' => $this->faker->sentence(),
             'created_at' => now(),
             'updated_at' => now(),
         ];
     }
 }



