<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $devUser = [
            'name' => 'Nguyễn Tiến Đạt',
            'email' => 'secretangent2112@gmail.com',
            'password' => Hash::make('21122003'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        User::insert($devUser);
    }
}
