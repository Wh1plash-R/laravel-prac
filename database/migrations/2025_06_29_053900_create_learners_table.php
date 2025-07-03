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
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('skill');
            $table->text('bio');
            $table->timestamps();
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade'); // Ensures that if a course is deleted, the related learners are also deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learners');
    }
};
