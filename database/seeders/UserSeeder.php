<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            // 'usertype' akan otomatis 'user' karena default
            'password' => 'password',
            'phone' => '089876543210',
            'address' => 'Jl. Pahlawan No. 10, Semarang',
            'foto_profile' => 'user.jpg',
        ]);
    }
}
