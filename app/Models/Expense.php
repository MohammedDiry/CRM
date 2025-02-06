<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'category', 'amount', 'description', 'date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
