<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin',
            'password' => 'password',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat, Jakarta',
            'foto_profile' => 'admin.jpg',
        ]);
    }
}
