<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'cashier',
            'email' => 'cashier@mail.com',
            'role' => 'cashier',
            'password' => bcrypt('rahasia123'),
            'status' => 'active'
        ]);

        $admin->assignRole('cashier');
    }
}
