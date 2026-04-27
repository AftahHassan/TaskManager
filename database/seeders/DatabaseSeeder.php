<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // 🔹 1. Créer utilisateurs
    User::factory()->count(5)->create();

    // 🔹 2. Catégories
    $this->call(CategorySeeder::class);

    // 🔹 3. Tâches
    $this->call(TaskSeeder::class);
}
}
