<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('learner_id')->constrained()->onDelete('cascade');
            $table->decimal('final_grade', 5, 2); // Grade as percentage (e.g., 85.50)
            $table->integer('total_points_earned');
            $table->integer('total_points_possible');
            $table->integer('assignments_completed');
            $table->integer('total_assignments');
            $table->timestamp('completed_at');
            $table->timestamps();

            // Ensure one completion record per learner per course
            $table->unique(['course_id', 'learner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_completions');
    }
};
