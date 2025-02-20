<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // المشروع المرتبط بالفاتورة
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            // بيانات الفاتورة
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['Pending', 'Paid', 'Overdue'])->default('Pending');

            $table->date('due_date');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->date('payment_date')->nullable(); // تاريخ السداد - سيتم تعبئته عند الدفع
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
