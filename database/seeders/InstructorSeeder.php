<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'name' => 'Instructor ' . $i,
                'email' => 'instructor' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ]);

            Instructor::create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);
        }
    }
}
