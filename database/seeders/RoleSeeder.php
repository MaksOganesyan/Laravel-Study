<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаём роли, если их ещё нет (idempotent — можно запускать много раз)
        Role::firstOrCreate(['name' => 'moderator']);
        Role::firstOrCreate(['name' => 'reader']);
    }
}
