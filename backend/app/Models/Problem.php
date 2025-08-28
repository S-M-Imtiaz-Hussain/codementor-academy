<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Model
{
    use SoftDeletes, HasFactory;


    protected $fillable = [
        'title',
        'description',
        'difficulty',
        'category',
        'test_cases'
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }   
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }   
    public function LearningPaths()
    {
        return $this->belongsToMany(LearningPath::class, 'path_problems','problem_id','path_id');
    }
}
