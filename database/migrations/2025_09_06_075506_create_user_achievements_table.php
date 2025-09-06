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
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('achievement_id'); // e.g., 'getting_started', 'course_explorer'
            $table->string('title');
            $table->text('description');
            $table->string('bg_class'); // e.g., 'from-blue-50 to-cyan-50'
            $table->string('border_class'); // e.g., 'border-blue-100'
            $table->string('icon_bg_class'); // e.g., 'from-blue-500 to-cyan-500'
            $table->string('icon_path'); // SVG path
            $table->timestamp('earned_at');
            $table->timestamps();

            // Ensure a user can't earn the same achievement twice
            $table->unique(['user_id', 'achievement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievements');
    }
};
