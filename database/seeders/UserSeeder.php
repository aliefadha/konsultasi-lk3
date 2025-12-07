<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          User::create([
            'name' => 'Administrator LK3',
            'email' => 'admin@lk3.org',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_ADMIN,
            'no_telepon' => '081234567890',
            'alamat' => 'Jakarta, Indonesia',
            'email_verified_at' => now(),
        ]);

        // Create Profesional Users
        User::create([
            'name' => 'Dr. Profesional',
            'email' => 'profesional@lk3.org',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_PROFESIONAL,
            'no_telepon' => '081234567891',
            'alamat' => 'Jakarta Selatan',
            'jenis_kelamin' => 'perempuan',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@email.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_KLIEN,
            'no_telepon' => '081234567894',
            'alamat' => 'Bekasi',
            'jenis_kelamin' => 'perempuan',
            'tanggal_lahir' => '1985-05-15',
            'nik' => '12312313123123',
            'email_verified_at' => now(),
        ]);
    }
}
