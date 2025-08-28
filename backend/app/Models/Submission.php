<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'problem_id',
        'code',
        'status',
        'language',
        'score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
    public function codeReviews()
    {
        return $this->hasMany(CodeReview::class);
    }   
}
