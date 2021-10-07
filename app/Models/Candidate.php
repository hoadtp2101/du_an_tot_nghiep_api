<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $table = "candidates";
    protected $fillable = [
        'name',
        'image',
        'phone',    
        'position',    
        'source',    
        'experience',    
        'school',    
        'cv',    
        'plan_id',
        'status'
    ];
}
