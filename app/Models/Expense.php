<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'category',
        'amount',
        'description',
        'invoice_id',
        'credited_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function creditedBy()
    {
        return $this->belongsTo(Employee::class, 'credited_by');
    }
}
