<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'name', 'description', 'start_date', 'end_date', 'budget', 'status'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function team()
    {
        return $this->belongsToMany(Employee::class, 'project_team');
    }

}
