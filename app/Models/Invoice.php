<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'invoice_number',
        'total_amount',
        'status',
        'due_date',
        'amount_paid',
        'payment_date',
        'notes',
    ];

    // العلاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // العلاقة غير المباشرة مع العميل من خلال المشروع
    public function client()
    {
        return $this->hasOneThrough(Client::class, Project::class, 'id', 'id', 'project_id', 'client_id');
    }
}

