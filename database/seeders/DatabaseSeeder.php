<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin Statis
        User::factory()->create([
            'name' => 'Kaise Administrator',
            'email' => 'admin@figstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun User (Pelanggan) Statis
        User::factory()->create([
            'name' => 'Kaise Customer',
            'email' => 'kaise@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // 3. Membuat 10 Akun User Acak (Otomatis menggunakan fake nama Indonesia & role 'user')
        User::factory(10)->create();
    }
}