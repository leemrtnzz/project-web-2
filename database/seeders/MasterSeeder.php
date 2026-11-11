<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'master@klikin.id'],
            [
                'name' => 'Master Administrator',
                'username' => 'master',
                'password' => Hash::make('password'),
                'role' => 'master',
                'bio' => 'Akun resmi Master Administrator KLIKIN. Mengawasi ketertiban, keamanan platform, dan berhak melakukan penangguhan terhadap pelanggar aturan.',
                'email_verified_at' => now(),
                'is_banned' => false,
                'banned_at' => null,
                'ban_reason' => null,
            ]
        );
    }
}
