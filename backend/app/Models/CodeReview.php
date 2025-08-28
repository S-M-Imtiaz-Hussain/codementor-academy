<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeReview extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'feedback',
        'ai_suggestions'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

}
