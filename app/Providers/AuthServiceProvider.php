<?php

namespace App\Providers;

use App\Models\Course;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Map models to policies here if you add dedicated Policy classes later
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-course', function ($user, Course $course) {
            return $user->isInstructor() && $course->instructor_id === $user->id;
        });
    }
}
