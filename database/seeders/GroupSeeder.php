<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create(['number_of_people' => 3, 'client_id' => 1]);
        Group::create(['number_of_people' => 5, 'client_id' => 2]);
    }
}
