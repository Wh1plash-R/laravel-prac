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
        ]);

        Learner::factory()->create([
            'name' => 'n-buna',
            'skill' => 'PHP',
            'bio' => 'Yorushika composer.',
        ]);

        Learner::factory()
            ->count(50)
            ->create();
    }
}
