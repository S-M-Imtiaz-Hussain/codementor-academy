<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathProblems extends Model
{
    use HasFactory;

    protected $table = 'path_problems';

    protected $fillable = [
        'path_id',
        'problem_id',
        'order',
        'is_required'
    ];
}
