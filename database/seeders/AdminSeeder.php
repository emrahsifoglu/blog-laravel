<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        'password' => 'password', //$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
        'email' => 'admin@example.com'
      ]);
    }
}
