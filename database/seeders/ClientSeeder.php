<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create(['last_name' => 'Smith', 'first_name' => 'John', 'address' => '123 Main St']);
        Client::create(['last_name' => 'Doe', 'first_name' => 'Jane', 'address' => '456 Secondary St']);
    }
}
