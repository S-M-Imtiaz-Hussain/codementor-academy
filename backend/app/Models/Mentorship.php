<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentorship extends Model
{
    use SoftDeletes, HasFactory;


    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'status'
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }   
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
