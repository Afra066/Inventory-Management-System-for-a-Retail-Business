<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@ipower.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Accountant User',
                'email' => 'accountant@ipower.com',
                'password' => Hash::make('password'),
                'role' => 'accountant',
            ],
            [
                'name' => 'Sales Staff User',
                'email' => 'staff@ipower.com',
                'password' => Hash::make('password'),
                'role' => 'sales_staff',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                ]
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}