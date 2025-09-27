<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           User::create([
            'name' => 'Super Admin',
            'email' => 'admin2@example.com',
            'phone' => '01111111111',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
    }

}
