<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Zhenansky',
            'email' => 'zhe@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
