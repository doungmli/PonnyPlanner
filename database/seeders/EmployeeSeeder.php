<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create(['last_name' => 'Durand', 'first_name' => 'Paul', 'role' => 'Instructor', 'email' => 'paul.durand@example.com']);
        Employee::create(['last_name' => 'Bernard', 'first_name' => 'Lucie', 'role' => 'Instructor', 'email' => 'lucie.bernard@example.com']);
    }
}
