<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
                    'name' => 'Ahmed Aboelsaoud',
                    'email' => 'admin@admin.com',
                    'password' => '123456789',
                ]);
        Role::firstOrCreate(['name' => 'Super Admin']);
        $user->assignRole('Super Admin');
    }
}
