<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    protected $fillable = [
        'title',
        'description',
        'department',
        'instructor_id',
    ];

    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public function learners()
    {
        return $this->belongsToMany(Learner::class)->withTimestamps();
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function courseCompletions()
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function completedLearners()
    {
        return $this->belongsToMany(Learner::class, 'course_completions')
                    ->withPivot('final_grade', 'total_points_earned', 'total_points_possible', 'assignments_completed', 'total_assignments', 'completed_at')
                    ->withTimestamps();
    }
}
