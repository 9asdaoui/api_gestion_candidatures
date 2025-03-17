<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    //     \App\Models\User::factory(10)->create();
    //     \App\Models\Offer::factory(10)->create();
    //     \App\Models\Application::factory(10)->create();
    //     \App\Models\Competence::factory(10)->create();
        \App\Models\Role::create(['name' => 'Admin']);
        \App\Models\Role::create(['name' => 'Candidat']);
        \App\Models\Role::create(['name' => 'Recruteur']);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
