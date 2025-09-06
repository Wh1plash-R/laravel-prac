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

    /**
     * Get enrolled learners (not completed)
     */
    public function enrolledLearners()
    {
        return $this->belongsToMany(Learner::class)
            ->wherePivot('status', 'enrolled')
            ->withPivot(['status', 'final_grade'])
            ->withTimestamps();
    }

    /**
     * Get completed learners
     */
    public function completedLearners()
    {
        return $this->belongsToMany(Learner::class)
            ->wherePivot('status', 'completed')
            ->withPivot(['status', 'final_grade'])
            ->withTimestamps();
    }

    /**
     * Calculate final grade for a learner based on all assignment scores
     */
    public function calculateFinalGrade(Learner $learner)
    {
        $assignments = $this->assignments;

        if ($assignments->isEmpty()) {
            return null;
        }

        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($assignments as $assignment) {
            $totalPoints += $assignment->points ?? 0;

            $submission = $assignment->submissions()
                ->where('learner_id', $learner->id)
                ->where('status', 'graded')
                ->first();

            if ($submission && $submission->grade !== null) {
                $earnedPoints += $submission->grade;
            }
        }

        if ($totalPoints == 0) {
            return null;
        }

        return round(($earnedPoints / $totalPoints) * 100, 2);
    }

    /**
     * Promote all enrolled students and mark them as completed (unenrolled from active enrollment)
     */
    public function promoteStudents()
    {
        // Get enrolled learners using the relationship method, not property
        $enrolledLearners = $this->enrolledLearners()->get();

        if ($enrolledLearners->isEmpty()) {
            return 0;
        }

        foreach ($enrolledLearners as $learner) {
            $finalGrade = $this->calculateFinalGrade($learner);

            // Update the pivot record with final grade and completed status
            // This effectively "unenrolls" them from active enrollment since enrolledLearners()
            // only returns students with status 'enrolled'
            $this->learners()->updateExistingPivot($learner->id, [
                'status' => 'completed',
                'final_grade' => $finalGrade,
                'updated_at' => now()
            ]);
        }

        // Reset course content
        $this->announcements()->delete();
        $this->assignments()->delete();

        return $enrolledLearners->count();
    }

    /**
     * Check if a learner can enroll (not already completed)
     */
    public function canEnroll(Learner $learner)
    {
        $enrollment = $this->learners()->where('learner_id', $learner->id)->first();

        if (!$enrollment) {
            return true; // Not enrolled at all
        }

        return $enrollment->pivot->status !== 'completed';
    }
}
