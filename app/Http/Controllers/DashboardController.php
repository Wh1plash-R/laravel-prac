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

        $learner = Learner::with('course')->firstWhere('user_id', $user->id); // firstWhere() = where()->first()
        $courses = Course::all();
        $course = $learner ?->course; // This is called "null safe" operator just like "$learner? learner -> course: null"

        return view('dashboard', compact('user', 'learner', 'courses', 'course'));
        // Compact() = $user => the current value of user etc.
    }

    public function update(Request $request, User $user)
    {
        $learner = Learner::where('user_id', $user->id)->first();

        if($request->input('unenroll'))
        {
            $learner->update([
                'course_id' => null,
            ]);
            return redirect()->route('dashboard')->with('success', 'Successfully unenrolled from course.');
        }

        if($request->input('course_id'))
        {
            if($learner->course_id){
            return redirect()->route('dashboard')->with('error', 'You are already enrolled in a course.');
            }
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);
            $learner->update([
                'course_id' => $request->input('course_id'),
            ]);
            return redirect()->route('dashboard')->with('success', 'Course updated successfully.');
        }

        else {
            $request->validate([
                'skill' => 'required|string|max:255',
                'bio' => 'required|string|max:500',
            ]);
            $learner->update($request->all());
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
        }
    }

}
