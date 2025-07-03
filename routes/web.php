<?php

use App\Http\Controllers\LearnerController;
use App\Http\Controllers\RouinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/rouin', [RouinController::class, 'rouin'])->name('rouin');


Route::get('/learners', [LearnerController::class, 'index'])->name('learners.index');
Route::get('/learners/add', [LearnerController::class, 'add'])->name('learners.add');
Route::get('/learners/{learner}',  [LearnerController::class, 'show'])->name('learners.show');
// instead of using /learners/{id} we use /learners/{learner} to match the model name since laravel uses route model binding
Route::post('/learners', [LearnerController::class, 'store'])->name('learners.store');
Route::delete('/learners/{learner}', [LearnerController::class, 'destroy'])->name('learners.destroy');
//important to use destroy instead of delete to match the RESTful convention
