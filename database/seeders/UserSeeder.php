<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@rs-bjm.test',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'unit' => 'IT',
            ],
            [
                'name' => 'Kepala IT',
                'email' => 'kepalait@rs-bjm.test',
                'password' => Hash::make('password123'),
                'role' => 'kepala_it',
                'unit' => 'IT',
            ],
            [
                'name' => 'Teknisi 1',
                'email' => 'teknisi1@rs-bjm.test',
                'password' => Hash::make('password123'),
                'role' => 'teknisi',
                'unit' => 'IT',
            ],
            [
                'name' => 'Teknisi 2',
                'email' => 'teknisi2@rs-bjm.test',
                'password' => Hash::make('password123'),
                'role' => 'teknisi',
                'unit' => 'IT',
            ],
            [
                'name' => 'Staff Pelapor',
                'email' => 'staff@rs-bjm.test',
                'password' => Hash::make('password123'),
                'role' => 'pelapor',
                'unit' => 'Rawat Jalan',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}