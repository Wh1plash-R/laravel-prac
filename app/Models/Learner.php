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
        return $this->belongsToMany(Course::class)->withPivot(['status', 'final_grade'])->withTimestamps();
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class)
            ->wherePivot('status', 'enrolled')
            ->withPivot(['status', 'final_grade'])
            ->withTimestamps();
    }

    public function completedCourses()
    {
        return $this->belongsToMany(Course::class)
            ->wherePivot('status', 'completed')
            ->withPivot(['status', 'final_grade'])
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
