<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Password statis yang di-cache agar proses seeding massal lebih cepat.
     */
    protected static ?string $password;

    /**
     * Tentukan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // fake('id_ID') akan memaksa Faker menggunakan format nama orang Indonesia
            'name' => fake('id_ID')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // Menggunakan password default 'password' jika belum didefinisikan
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            
            // Kolom kustom yang kita tambahkan di migrasi sebelumnya
            'role' => 'user', 
        ];
    }

    /**
     * State khusus jika Anda ingin meng-generate admin secara acak (Opsional)
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}