<?php

namespace Database\Seeders;

use App\Models\Learner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LearnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Learner::factory()->create([
            'name' => 'suis',
            'skill' => 'PHP',
            'bio' => 'Yorushika vocalist.',
            'course_id' => 1,
        ]);

        Learner::factory()->create([
            'name' => 'n-buna',
            'skill' => 'PHP',
            'bio' => 'Yorushika composer.',
            'course_id' => 1,
        ]);

        Learner::factory()
            ->count(50)
            ->create();
    }
}
