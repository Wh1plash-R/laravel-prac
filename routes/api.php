<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LearnerController as ApiLearnerController;

Route::middleware('auth:sanctum')->group(function () {
    Route::delete(
        'api/learners/{id}',
        [ApiLearnerController::class, 'destroy']
    )->name('api.learners.destroy');
});
