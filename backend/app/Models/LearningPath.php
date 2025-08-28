<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningPath extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'difficulty_level'
    ];

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'path_problems','path_id','problem_id')
                    ->withPivot('order','is_required')
                    ->withTimestamps();
    }
}
