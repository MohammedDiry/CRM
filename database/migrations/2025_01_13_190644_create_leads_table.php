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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('status', ['New', 'Contacted', 'Won', 'Lost'])->default('New');
            $table->enum('source', ['Social Media', 'Website', 'Referral', 'Other'])->default('Other');
            $table->foreignId('assigned_to')->constrained('employees'); // Employee responsible for the lead
            $table->dateTime('converted_at')->nullable(); // New column for conversion date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
