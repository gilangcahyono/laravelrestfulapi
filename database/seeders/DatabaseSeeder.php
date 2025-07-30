<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->has(Contact::factory(3))->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(50)->has(Contact::factory(5))->create();
    }
}
