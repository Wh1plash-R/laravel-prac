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
    ];

    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    public function learners()
    {
        return $this->hasMany(Learner::class);
    }
}
