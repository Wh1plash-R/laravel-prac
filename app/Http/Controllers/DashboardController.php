<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Learner;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->isAdmin())
        {
            $redirect = redirect()->route('learners.index');
            if (session()->has('success')) {
                $redirect = $redirect->with('success', session('success'));
            }
            return $redirect;
        }
        elseif($user->isInstructor())
        {
            return redirect()->route('instructor.index');
        }

        $learner = Learner::with('courses')->firstWhere('user_id', $user->id); // firstWhere() = where()->first()
        $courses = Course::all();
        $learner_courses = $learner ?->courses; // This is called "null safe" operator just like "$learner? learner -> course: null"
        $course = $learner_courses->first(); // what's the point of this?

        return view('dashboard', compact('user', 'learner', 'courses', 'learner_courses', 'course'));
        // Compact() = $user => the current value of user etc.
    }

    public function showCourse(Course $course)
    {
        $user = auth()->user();
        $learner = Learner::where('user_id', $user->id)->firstOrFail();

        $isEnrolled = $learner->courses()->where('course_id', $course->id)->exists();

        if (!$isEnrolled) {
            return redirect()->route('dashboard')->with('error', 'You are not enrolled in this course.');
        }

        $course->load(['instructor', 'announcements', 'assignments']);

        return view('learners.course-view', compact('course', 'user', 'learner'));
    }

    public function update(Request $request, User $user)
    {
        $learner = Learner::where('user_id', $user->id)->firstOrFail();

        if (!$learner) {
            return redirect()->route('dashboard')->with('error', 'Learner profile not found.');
        }

        if ($request->boolean('unenroll') && $request->filled('course_id'))
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);
            $learner->courses()->detach($request->input('course_id'));
            return redirect()->route('dashboard')->with('success', 'Successfully unenrolled from course.');
        }


        if ($request->filled('course_ids'))
        {
            $request->validate([
                'course_ids' => 'array',
                'course_ids.*' => 'integer|exists:courses,id',
            ]);
            $learner->courses()->syncWithoutDetaching($request->input('course_ids'));
            return redirect()->route('dashboard')->with('success', 'Courses enrolled successfully.');
        }

        if ($request->filled('course_id'))
        {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);
            $learner->courses()->syncWithoutDetaching([$request->input('course_id')]);
            return redirect()->route('dashboard')->with('success', 'Course enrolled successfully.');
        }

        // Handle profile updates (skill, bio, and profile picture)
        else
        {
            $request->validate([
                'skill' => 'nullable|string|max:255',
                'bio' => 'nullable|string|max:500',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $learnerData = $request->only(['skill', 'bio']);
            if (!empty($learnerData)) {
                $learner->update($learnerData);
            }

            if ($request->hasFile('profile_picture')) {
                $imageData = file_get_contents($request->file('profile_picture')->getRealPath());
                $user->update(['profile_picture' => $imageData]);
            }

            $learner->update($request->only(['skill', 'bio']));
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

    public function deleteProfilePicture(User $user)
    {
        // Ensure the authenticated user can only delete their own profile picture
        if (auth()->user()->id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        // Remove the profile picture by setting it to null
        $user->update(['profile_picture' => null]);

        return redirect()->route('dashboard')->with('success', 'Profile picture removed successfully.');
    }

}
