<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    protected $fillable = ['name', 'skill', 'bio', 'course_id', 'user_id'];

    /** @use HasFactory<\Database\Factories\LearnerFactory> */
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
