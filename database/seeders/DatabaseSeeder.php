<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RolesTableSeeder::class);
        // $this->call(SettingsSeeder::class);
    }
}
