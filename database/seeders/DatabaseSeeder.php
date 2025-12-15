<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Сначала обязательно роли
        $this->call(RoleSeeder::class);

        // Создаём 10 обычных читателей
        User::factory(10)->create([
            'role_id' => Role::where('name', 'reader')->first()->id,
        ]);

        // Создаём одного модератора (для тестов)
        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'), // или Hash::make('password')
            'role_id' => Role::where('name', 'moderator')->first()->id,
        ]);

        // Создаём 20 статей с комментариями
        Article::factory(20)->create();
    }
}
