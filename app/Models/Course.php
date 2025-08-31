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
}
