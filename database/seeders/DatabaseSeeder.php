<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Apps\MenuSeeder;
use Database\Seeders\Apps\RoleHasMenuSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(RoleHasMenuSeeder::class);
    }
}
