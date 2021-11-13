<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    use HasFactory;
    protected $table = 'job_requests';
    protected $fillable = [
        'title',
        'description',
        'position',
        'amount',
        'location',
        'working_time',
        'petitioner',
        'wage',
        'status',
        'deadline',
        'reason',
    ];

    public function petitioner(){
        return $this->belongsTo(User::class, 'petitioner', 'id');
    }
}
