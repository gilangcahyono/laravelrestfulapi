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
        User::factory()->has(Contact::factory(15))->create([
            'name' => 'Gilang',
            'email' => 'gilang@gmail.com',
        ]);

        User::factory()->has(Contact::factory(15))->create([
            'name' => 'Riris',
            'email' => 'riris@gmail.com',
        ]);

        User::factory(3)->has(Contact::factory(15))->create();
    }
}
