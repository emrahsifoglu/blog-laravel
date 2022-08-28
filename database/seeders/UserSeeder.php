<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
          'name' => 'Johnny',
          'surname' => 'Depp',
          'nickname' => 'deppjoh',
          'email' => 'deppjoh@example.com'
        ]);
    }
}
