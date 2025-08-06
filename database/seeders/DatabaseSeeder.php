<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory()->create([
            'fullname' => 'Suyono',
            'username' => 'yono',
            'email' => 'yono@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '081234567890',
            'role_id' => 1,
        ]);
    }
}
