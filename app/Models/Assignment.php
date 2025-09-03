<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'due_date',
        'status',
        'points',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'green',
            'locked' => 'gray',
            'completed' => 'blue',
            default => 'gray',
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'active' => 'Active',
            'locked' => 'Locked',
            'completed' => 'Completed',
            default => 'Unknown',
        };
    }
}
