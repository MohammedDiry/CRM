<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'status', 'source', 'assigned_to', 'notes', 'converted_at'

    ];

    protected $casts = [
        'converted_at' => 'datetime', // To ensure the 'converted_at' column is cast to datetime
    ];

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
