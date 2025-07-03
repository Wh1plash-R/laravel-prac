<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouinController;
use App\Http\Controllers\LearnerController;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/rouin', [RouinController::class, 'rouin'])->name('rouin');


Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/learners', [LearnerController::class, 'index'])->name('learners.index');
    Route::get('/learners/add', [LearnerController::class, 'add'])->name('learners.add');
    Route::get('/learners/{learner}',  [LearnerController::class, 'show'])->name('learners.show');
    // instead of using /learners/{id} we use /learners/{learner} to match the model name since laravel uses route model binding
    Route::post('/learners', [LearnerController::class, 'store'])->name('learners.store');
    Route::delete('/learners/{learner}', [LearnerController::class, 'destroy'])->name('learners.destroy');
    //important to use destroy instead of delete to match the RESTful convention
    Route::get('/learners/{learner}/edit', [LearnerController::class, 'edit'])->name('learners.edit');
    Route::patch('/learners/{learner}', [LearnerController::class, 'update'])->name('learners.update');
});


require __DIR__.'/auth.php';
