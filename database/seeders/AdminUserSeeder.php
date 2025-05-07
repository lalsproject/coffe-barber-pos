<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            'password' => bcrypt('rahasia123'),
            'status' => 'active'
        ]);

        $admin->assignRole('admin');
    }
}
