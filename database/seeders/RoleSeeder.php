<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Role::create([
            'name' => 'admin',
            'description' => 'Administrator for the entire platform',
        ]);

        Role::create([
            'name' => 'user',
            'description' => 'Regular user or learners',
        ]);

        Role::create([
            'name' => 'instructor',
            'description' => 'Instructor of the courses',
        ]);
    }
}
