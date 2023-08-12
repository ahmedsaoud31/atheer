<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AtheerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            PermissionsSeeder::class,
        ]);
    }
}
