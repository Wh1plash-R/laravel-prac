<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'learner_id',
        'final_grade',
        'total_points_earned',
        'total_points_possible',
        'assignments_completed',
        'total_assignments',
        'completed_at',
    ];

    protected $casts = [
        'final_grade' => 'decimal:2',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    public function getGradeLetterAttribute()
    {
        $grade = $this->final_grade;

        if ($grade >= 97) return 'A+';
        if ($grade >= 90) return 'A';
        if ($grade >= 80) return 'B';
        if ($grade >= 70) return 'C';
        if ($grade >= 65) return 'D';
        return 'F';
    }

    public function getGradeColorAttribute()
    {
        $grade = $this->final_grade;

        if ($grade >= 90) return 'green';
        if ($grade >= 80) return 'blue';
        if ($grade >= 70) return 'yellow';
        if ($grade >= 65) return 'orange';
        return 'red';
    }
}
