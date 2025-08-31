<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'info' => 'blue',
            'warning' => 'yellow',
            'success' => 'green',
            'important' => 'red',
            default => 'blue',
        };
    }
}
