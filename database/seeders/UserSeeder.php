<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'username' => 'rasyid',
                'email' => 'rasyid@gmail.com',
                'password' => bcrypt('Admin.123'),
            ],
        ];

        foreach ($users as $us) {
            User::create($us);
        }
    }
}
