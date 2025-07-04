<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;
use App\Models\Course;
class LearnerController extends Controller
{

    public function index()
    {
        return view('learners.index', [
            "mentor" => 'suis',
            "learners" => Learner::with('course')->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function show(Learner $learner)
    {
        /* There is this thing called Route model binding that automatically resolves the learner by ID
        and passes it to the method as a parameter */
        $learner->load('course'); // This one "eager loads" the course relationship, meaning nilo-load na lahat
        return view('learners.show', ['learner' => $learner]);
    }

    public function add()
    {
        $courses = Course::all();
        return view('learners.add', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'skill' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        Learner::create($validated_data);

        return redirect()->route('learners.index')->with('success', 'Learner added successfully!');
    }

    public function update(Request $request, Learner $learner)
    {
        $learner->update($request->all());
        return;
    }

    public function destroy(Learner $learner){
        // have to delete the user to avoid unexpected things?
        if ($learner->user) {
            $learner->user()->delete();
        }
        $learner->delete();
        return redirect()->route('learners.index')->with('success', 'Learner deleted successfully!');
    }

}
