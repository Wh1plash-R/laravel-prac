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
    Route::get('/course/{course}', [DashboardController::class, 'showCourse'])->name('course.view');
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
    Route::post('/instructor/course/{course}/activity', [InstructorController::class, 'storeActivity'])->name('instructor.activity.store');
});


require __DIR__.'/auth.php';
