<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \App\Models\User::factory()->create([
        'name' => 'Admin',
        'surname' => 'User',
        'nickname' => 'admin',
        'role' => 5,
        'email' => 'admin@example.com'
      ]);
    }
}
