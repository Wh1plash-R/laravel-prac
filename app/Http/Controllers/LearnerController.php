<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class LearnerController extends Controller
{

    public function index()
    {
        return view('learners.index', [
            "mentor" => 'Rouin',
            "learners" => Learner::with('courses')->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function show(Learner $learner)
    {
        /* There is this thing in Laravel
         called Route model binding that automatically
         resolves the learner by ID
        and passes it to the method as a parameter
        Naming Convention (never forget)
        */
        $learner->with('courses');
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
            'courses' => 'nullable|exists:courses,id',
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

    /**
     * View assignment details for learner
     */
    public function viewAssignment(Assignment $assignment)
    {
        $user = Auth::user();
        $learner = $user->learner;

        if (!$learner) {
            abort(403, 'Access denied. Learner profile not found.');
        }

        if (!$learner->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $assignment->load('course');
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $learner->id)
            ->first();

        if ($assignment->status === 'locked' && !$submission) {
            abort(403, 'This assignment is locked and you have no existing submission to view.');
        }

        return view('learners.assignment-view', [
            'assignment' => $assignment,
            'submission' => $submission,
            'learner' => $learner,
            'user' => $user
        ]);
    }

    /**
     * Submit or update assignment submission
     */
    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $user = Auth::user();
        $learner = $user->learner;

        if (!$learner) {
            abort(403, 'Access denied. Learner profile not found.');
        }

        if (!$learner->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        if ($assignment->status === 'locked') {
            return redirect()->back()->with('error', 'This assignment is locked and cannot be modified.');
        }

        $submission = Submission::firstOrCreate(
            [
                'assignment_id' => $assignment->id,
                'learner_id' => $learner->id
            ],
            ['status' => 'draft']
        );

        if (!$submission->canBeEdited()) {
            return redirect()->back()->with('error', 'This submission has already been finalized and cannot be edited.');
        }

        $validated = $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,zip|max:10240', // 10MB max
            'comments' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('file')) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', $fileName, 'public');

            $submission->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'comments' => $validated['comments'] ?? $submission->comments,
            ]);
        } else {
            $submission->update([
                'comments' => $validated['comments'] ?? $submission->comments,
            ]);
        }

        return redirect()->back()->with('success', 'Assignment updated successfully!');
    }

    /**
     * Remove uploaded file from submission
     */
    public function removeSubmission(Assignment $assignment)
    {
        $user = Auth::user();
        $learner = $user->learner;

        if (!$learner) {
            abort(403, 'Access denied. Learner profile not found.');
        }

        if ($assignment->status === 'locked') {
            return redirect()->back()->with('error', 'This assignment is locked and cannot be modified.');
        }

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $learner->id)
            ->first();

        if (!$submission) {
            return redirect()->back()->with('error', 'No submission found.');
        }

        if (!$submission->canBeEdited()) {
            return redirect()->back()->with('error', 'This submission has already been finalized and cannot be edited.');
        }

        // Delete file from storage
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->update([
            'file_path' => null,
            'file_name' => null,
            'file_type' => null,
            'file_size' => null,
        ]);

        return redirect()->back()->with('success', 'File removed successfully!');
    }

    /**
     * Finalize submission (submit for grading)
     */
    public function finalizeSubmission(Assignment $assignment)
    {
        $user = Auth::user();
        $learner = $user->learner;

        if (!$learner) {
            abort(403, 'Access denied. Learner profile not found.');
        }

        if ($assignment->status === 'locked') {
            return redirect()->back()->with('error', 'This assignment is locked and cannot be modified.');
        }

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $learner->id)
            ->first();

        if (!$submission) {
            return redirect()->back()->with('error', 'No submission found. Please upload a file first.');
        }

        if (!$submission->canBeEdited()) {
            return redirect()->back()->with('error', 'This submission has already been finalized.');
        }

        if (!$submission->file_path) {
            return redirect()->back()->with('error', 'Please upload a file before submitting.');
        }

        $submission->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Assignment submitted successfully! You can no longer make changes.');
    }

    /**
     * Download submission file
     */
    public function downloadSubmission(Assignment $assignment)
    {
        $user = Auth::user();
        $learner = $user->learner;

        if (!$learner) {
            abort(403, 'Access denied. Learner profile not found.');
        }

        // Check if learner is enrolled in the course
        if (!$learner->courses()->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('learner_id', $learner->id)
            ->first();

        if (!$submission || !$submission->file_path) {
            abort(404, 'File not found.');
        }

        $filePath = storage_path('app/public/' . $submission->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found on server.');
        }

        return response()->download($filePath, $submission->file_name);
    }

}
