<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_id',
        'title',
        'description',
        'bg_class',
        'border_class',
        'icon_bg_class',
        'icon_path',
        'earned_at',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all possible achievements with their criteria
     */
    public static function getPossibleAchievements(): array
    {
        return [
            [
                'id' => 'getting_started',
                'title' => 'Getting Started',
                'description' => 'Enrolled in your first course or made your first submission',
                'bg_class' => 'from-blue-50 to-cyan-50',
                'border_class' => 'border-blue-100',
                'icon_bg_class' => 'from-blue-500 to-cyan-500',
                'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z',
            ],
            [
                'id' => 'course_explorer',
                'title' => 'Course Explorer',
                'description' => 'Enrolled in 3+ courses',
                'bg_class' => 'from-yellow-50 to-orange-50',
                'border_class' => 'border-yellow-100',
                'icon_bg_class' => 'from-yellow-400 to-orange-500',
                'icon_path' => 'M12 20l9-5-9-5-9 5 9 5zm0-12l9-5-9-5-9 5 9 5z',
            ],
            [
                'id' => 'high_achiever',
                'title' => 'High Achiever',
                'description' => 'Maintains 75%+ average progress',
                'bg_class' => 'from-purple-50 to-pink-50',
                'border_class' => 'border-purple-100',
                'icon_bg_class' => 'from-purple-500 to-pink-500',
                'icon_path' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
            ],
            [
                'id' => 'consistent',
                'title' => 'Consistent',
                'description' => '24 hours of learning completed',
                'bg_class' => 'from-blue-50 to-cyan-50',
                'border_class' => 'border-blue-100',
                'icon_bg_class' => 'from-blue-500 to-cyan-500',
                'icon_path' => 'M13 10V3L4 14h7v7l9-11h-7z',
            ],
            [
                'id' => 'assignment_champ',
                'title' => 'Assignment Champ',
                'description' => 'Completed 5+ assignments',
                'bg_class' => 'from-green-50 to-emerald-50',
                'border_class' => 'border-green-100',
                'icon_bg_class' => 'from-green-500 to-emerald-500',
                'icon_path' => 'M5 13l4 4L19 7',
            ],
        ];
    }

    /**
     * Award an achievement to a user if they haven't earned it yet
     */
    public static function awardAchievement(int $userId, string $achievementId): ?UserAchievement
    {
        // Check if user already has this achievement
        $existing = self::where('user_id', $userId)
            ->where('achievement_id', $achievementId)
            ->first();

        if ($existing) {
            return $existing;
        }

        // Get achievement details
        $possibleAchievements = self::getPossibleAchievements();
        $achievementData = collect($possibleAchievements)
            ->firstWhere('id', $achievementId);

        if (!$achievementData) {
            return null;
        }

        // Award the achievement
        return self::create([
            'user_id' => $userId,
            'achievement_id' => $achievementId,
            'title' => $achievementData['title'],
            'description' => $achievementData['description'],
            'bg_class' => $achievementData['bg_class'],
            'border_class' => $achievementData['border_class'],
            'icon_bg_class' => $achievementData['icon_bg_class'],
            'icon_path' => $achievementData['icon_path'],
            'earned_at' => now(),
        ]);
    }
}
