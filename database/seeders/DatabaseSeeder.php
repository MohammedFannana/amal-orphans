<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'جمعية مناصرة فلسطين',
            // 'id_number' => '٨٢١١٠١٢٧٧',
            'email' => '1000hope.orphans@gmail.com',
            'password' => Hash::make('1000hope#2025')
        ]);
    }
}
