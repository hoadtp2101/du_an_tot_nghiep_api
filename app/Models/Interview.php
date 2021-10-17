<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $table = "interviews";

    protected $fillable = [
        'job_id',
        'round_no',
        'position',
        'time',
        'title',
        'receiver',
        'name_candidate'
    ];
    
}
