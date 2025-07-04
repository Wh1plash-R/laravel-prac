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
        if($user->isAdmin()) {
            return redirect()->route('learners.index');
        }
        $learner = Learner::with('course')->where('user_id', auth()->id())->first();
        $course = $learner ? $learner->course : null;
        return view('dashboard', ['courses' => Course::all(),'course' => $course, 'user' => auth()->user(), 'learner' => $learner]);
    }

    public function update(Request $request, User $user)
    {
        $learner = Learner::where('user_id', $user->id)->first();
        if($request->input('course_id')) {
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
