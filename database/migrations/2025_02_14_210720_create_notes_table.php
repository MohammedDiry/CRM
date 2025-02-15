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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->text('note'); // نص الملاحظة
            $table->nullableMorphs('noteable'); // العلاقة المشتركة (إما عميل أو عميل محتمل)
            $table->foreignId('employee_id')->constrained('employees'); // ربط الملاحظة بالموظف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
