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

        $course->load('instructor');

        return view('learners.course-view', compact('course', 'user', 'learner'));
    }

    public function update(Request $request, User $user)
    {
        $learner = Learner::where('user_id', $user->id)->firstOrFail();

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

        else
        {
            $request->validate([
                'skill' => 'required|string|max:255',
                'bio' => 'required|string|max:500',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            ]);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $imageData = file_get_contents($request->file('profile_picture'));
                $user->update(['profile_picture' => $imageData]);
            }

            $learner->update($request->only(['skill', 'bio']));
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

}
