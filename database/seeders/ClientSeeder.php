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
        Client::create(['last_name' => 'Smith', 'first_name' => 'John', 'address' => '123 Main St','email'=>'smith_john@example.com']);
        Client::create(['last_name' => 'Doe', 'first_name' => 'Jane', 'address' => '456 Secondary St','email'=>'doe_jane@example.com']);
    }
}
