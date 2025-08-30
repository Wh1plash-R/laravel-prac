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

        $learner = Learner::with('courses')->firstWhere('user_id', $user->id); // firstWhere() = where()->first()
        $courses = Course::all();
        $learner_courses = $learner ?->courses; // This is called "null safe" operator just like "$learner? learner -> course: null"
        $course = $learner_courses->first(); // what's the point of this?

        return view('dashboard', compact('user', 'learner', 'courses', 'learner_courses', 'course'));
        // Compact() = $user => the current value of user etc.
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

        // Enroll a single course
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
            ]);
            $learner->update($request->all());
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

}
