<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouinController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\InstructorController;


Route::get('/rouin', [RouinController::class, 'rouin'])->name('rouin');
Route::get('/', [RouinController::class, 'welcome'])->middleware('guest')->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/{user}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/{user}/profile-picture', [DashboardController::class, 'deleteProfilePicture'])->name('dashboard.delete-profile-picture');
    Route::get('/course/{course}', [DashboardController::class, 'showCourse'])->name('course.view');

    // Assignment view routes for learners
    Route::get('/assignment/{assignment}', [LearnerController::class, 'viewAssignment'])->name('assignment.view');
    Route::post('/assignment/{assignment}/submit', [LearnerController::class, 'submitAssignment'])->name('assignment.submit');
    Route::delete('/assignment/{assignment}/submission', [LearnerController::class, 'removeSubmission'])->name('assignment.remove');
    Route::patch('/assignment/{assignment}/finalize', [LearnerController::class, 'finalizeSubmission'])->name('assignment.finalize');
    Route::get('/assignment/{assignment}/download', [LearnerController::class, 'downloadSubmission'])->name('assignment.download');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/learners', [LearnerController::class, 'index'])->name('learners.index');
    Route::get('/learners/add', [LearnerController::class, 'add'])->name('learners.add');
    // don't use /add in the future anymore, and use create instead dahil 'yun ang RESTful convention
    Route::get('/learners/{learner}',  [LearnerController::class, 'show'])->name('learners.show');
    // instead of using /learners/{id} we use /learners/{learner} to match the model name since Laravel uses "route model binding"
    Route::post('/learners', [LearnerController::class, 'store'])->name('learners.store');
    Route::delete('/learners/{learner}', [LearnerController::class, 'destroy'])->name('learners.destroy');
    // important to use destroy instead of delete to match the convention
    Route::get('/learners/{learner}/edit', [LearnerController::class, 'edit'])->name('learners.edit');
    Route::patch('/learners/{learner}', [LearnerController::class, 'update'])->name('learners.update');
});

// Instructor routes - for instructors managing their courses
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/courses', [InstructorController::class, 'index'])->name('instructor.index');
    Route::get('/instructor/course/{course}', [InstructorController::class, 'courseView'])->name('instructor.course.view');
    Route::post('/instructor/course/{course}/announcement', [InstructorController::class, 'storeAnnouncement'])->name('instructor.announcement.store');
    Route::get('/instructor/announcement/{announcement}/edit', [InstructorController::class, 'editAnnouncement'])->name('instructor.announcement.edit');
    Route::patch('/instructor/announcement/{announcement}', [InstructorController::class, 'updateAnnouncement'])->name('instructor.announcement.update');
    Route::delete('/instructor/announcement/{announcement}', [InstructorController::class, 'destroyAnnouncement'])->name('instructor.announcement.destroy');
    Route::post('/instructor/course/{course}/activity', [InstructorController::class, 'storeActivity'])->name('instructor.activity.store');
    Route::get('/instructor/assignment/{assignment}/edit', [InstructorController::class, 'editAssignment'])->name('instructor.assignment.edit');
    Route::patch('/instructor/assignment/{assignment}', [InstructorController::class, 'updateAssignment'])->name('instructor.assignment.update');
    Route::delete('/instructor/assignment/{assignment}', [InstructorController::class, 'destroyAssignment'])->name('instructor.assignment.destroy');

    // Assignment view and grading routes for instructors
    Route::get('/instructor/assignment/{assignment}', [InstructorController::class, 'viewAssignment'])->name('instructor.assignment.view');
    Route::post('/instructor/assignment/{assignment}/grade', [InstructorController::class, 'gradeSubmission'])->name('instructor.assignment.grade');
    Route::get('/instructor/assignment/{assignment}/download/{learner}', [InstructorController::class, 'downloadSubmission'])->name('instructor.assignment.download');
    Route::patch('/instructor/assignment/{assignment}/lock', [InstructorController::class, 'lockAssignment'])->name('instructor.assignment.lock');
    Route::patch('/instructor/assignment/{assignment}/unlock', [InstructorController::class, 'unlockAssignment'])->name('instructor.assignment.unlock');

    // Course completion route
    Route::post('/instructor/course/{course}/promote', [InstructorController::class, 'promoteStudents'])->name('instructor.course.promote');
});


require __DIR__.'/auth.php';
