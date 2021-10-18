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
        'source',    
        'experience',    
        'school',    
        'cv',    
        'job_id',
        'status'
    ];
}
