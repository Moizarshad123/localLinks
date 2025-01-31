<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id'  => 1,
            'name'     => 'Nasa Admin',
            'email'    => 'admin@nasa.com',
            'password' => Hash::make('admin@123'),
            'status'   => 1
        ]);
    }
}
