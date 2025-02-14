<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class
UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $adminRole = Role::where('name', 'admin')->first();
            $staffRole = Role::where('name', 'staff')->first();
            $employeeRole = Role::where('name', 'employee')->first();

            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]);

            User::create([
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => bcrypt('password'),
                'role_id' => $staffRole->id,
            ]);

            User::create([
                'name' => 'Employee User',
                'email' => 'employee@example.com',
                'password' => bcrypt('password'),
                'role_id' => $employeeRole->id,
            ]);
        }
}
