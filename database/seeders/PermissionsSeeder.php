<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Atheer;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Atheer::getPermissions() as $name){
            foreach(Atheer::getTables() as $table){
                Permission::firstOrCreate(['name' => "{$name} {$table}"]);
            }
        }
    }
}
