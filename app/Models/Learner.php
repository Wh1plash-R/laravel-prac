<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    protected $fillable = ['name', 'skill', 'bio', 'user_id'];

    /** @use HasFactory<\Database\Factories\LearnerFactory> */
    use HasFactory;

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function courseCompletions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function completedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_completions')
                    ->withPivot('final_grade', 'total_points_earned', 'total_points_possible', 'assignments_completed', 'total_assignments', 'completed_at')
                    ->withTimestamps();
    }
}
