<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_learner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('learner_id')->constrained('learners')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['course_id', 'learner_id']);
        });

        // Backfill existing one-to-many data
        $pairs = DB::table('learners')
            ->whereNotNull('course_id')
            ->select('course_id', 'id as learner_id')
            ->get();

        foreach ($pairs as $p) {
            DB::table('course_learner')->insert([
                'course_id' => $p->course_id,
                'learner_id' => $p->learner_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (Schema::hasColumn('learners', 'course_id')) {
            try {
                Schema::table('learners', function (Blueprint $table) {
                    $table->dropForeign(['course_id']);
                });
            } catch (\Throwable $e) {
                // ignore if not enforced (e.g., SQLite)
            }

            Schema::table('learners', function (Blueprint $table) {
                $table->dropColumn('course_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('learners', 'course_id')) {
            Schema::table('learners', function (Blueprint $table) {
                $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            });
        }

        // Optional: backfill a single course_id from pivot on rollback
        $pairs = DB::table('course_learner')
            ->select('learner_id', DB::raw('MIN(course_id) as course_id'))
            ->groupBy('learner_id')
            ->get();

        foreach ($pairs as $p) {
            DB::table('learners')->where('id', $p->learner_id)->update(['course_id' => $p->course_id]);
        }

        Schema::dropIfExists('course_learner');
    }
};
