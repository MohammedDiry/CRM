<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'phone', 'company_name', 'address', 'feedback'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
