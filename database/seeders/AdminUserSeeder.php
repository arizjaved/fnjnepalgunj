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
            'name' => 'FNJ Admin',
            'email' => 'admin@fnjnepal.org',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'FNJ Editor',
            'email' => 'editor@fnjnepal.org',
            'password' => Hash::make('editor123'),
            'role' => 'editor',
            'is_active' => true,
        ]);
    }
}
