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
        Schema::table('course_learner', function (Blueprint $table) {
            $table->enum('status', ['enrolled', 'completed'])->default('enrolled')->after('learner_id');
            $table->decimal('final_grade', 5, 2)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_learner', function (Blueprint $table) {
            $table->dropColumn(['status', 'final_grade']);
        });
    }
};
