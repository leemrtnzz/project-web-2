<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Demo Creator (Active user with several categories & products)
        $demoUser = User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo Creator',
                'username' => 'demo',
                'password' => Hash::make('password'),
                'role' => 'user',
                'bio' => 'Rekomendasi produk pilihan yang bikin hidup makin gampang. Semua link affiliate terverifikasi dan aman!',
                'email_verified_at' => now(),
                'is_banned' => false,
                'banned_at' => null,
                'ban_reason' => null,
            ]
        );

        $demoCategories = collect(['Gadget', 'Kecantikan', 'Rumah Tangga'])
            ->mapWithKeys(fn (string $name) => [
                $name => $demoUser->categories()->firstOrCreate(['name' => $name]),
            ]);

        collect([
            ['Gadget', 'TWS Bluetooth Pro Stereo', 'tws', 42],
            ['Gadget', 'Mechanical Keyboard 65% RGB', 'keyboard', 19],
            ['Gadget', 'Powerbank 20.000mAh Fast Charging', 'powerbank', 31],
            ['Kecantikan', 'Sunscreen SPF 50 PA++++', 'sunscreen', 85],
            ['Kecantikan', 'Serum Niacinamide 10% Brightening', 'serum', 54],
            ['Rumah Tangga', 'Air Fryer Digital 5L Low Watt', 'airfryer', 28],
            ['Rumah Tangga', 'Lampu Meja Belajar Minimalis', 'lampu', 15],
        ])->each(function (array $product) use ($demoUser, $demoCategories) {
            [$category, $title, $seed, $clicks] = $product;

            $demoUser->affiliateProducts()->firstOrCreate(
                [
                    'category_id' => $demoCategories[$category]->id,
                    'title' => $title,
                ],
                [
                    'image' => "https://picsum.photos/seed/{$seed}/600/600",
                    'affiliate_url' => "https://example.com/aff/{$seed}",
                    'count' => $clicks,
                ]
            );
        });

        // 2. Regular Creator (Active user: Budi)
        $budiUser = User::updateOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'username' => 'budisantoso',
                'password' => Hash::make('password'),
                'role' => 'user',
                'bio' => 'Sharing buku bacaan dan kursus koding favorit. Belajar web programming dari nol sampai jago.',
                'email_verified_at' => now(),
                'is_banned' => false,
                'banned_at' => null,
                'ban_reason' => null,
            ]
        );

        $budiCategory = $budiUser->categories()->firstOrCreate(['name' => 'Buku & Edukasi']);
        $budiUser->affiliateProducts()->firstOrCreate(
            [
                'category_id' => $budiCategory->id,
                'title' => 'Buku Pemrograman Web Modern dengan Laravel',
            ],
            [
                'image' => 'https://picsum.photos/seed/bookdev/600/600',
                'affiliate_url' => 'https://example.com/aff/buku-laravel',
                'count' => 12,
            ]
        );

        // 3. Banned User (Violating user to showcase DO NOT CROSS banner)
        $bannedUser = User::updateOrCreate(
            ['email' => 'violator@example.com'],
            [
                'name' => 'Spammer Nakal',
                'username' => 'violator',
                'password' => Hash::make('password'),
                'role' => 'user',
                'bio' => 'Dapatkan hadiah iPhone 16 gratis dengan klik tautan di bawah ini!',
                'email_verified_at' => now(),
                'is_banned' => true,
                'banned_at' => now()->subDays(1)->setHour(14)->setMinute(30),
                'ban_reason' => 'Melanggar Ketentuan Layanan: Memasang tautan affiliate phising dan penipuan undian palsu.',
            ]
        );

        $bannedCategory = $bannedUser->categories()->firstOrCreate(['name' => 'Promo Undian Palsu']);
        $bannedUser->affiliateProducts()->firstOrCreate(
            [
                'category_id' => $bannedCategory->id,
                'title' => 'Klaim Hadiah iPhone 16 Pro Rp 0',
            ],
            [
                'image' => 'https://picsum.photos/seed/fakeiphone/600/600',
                'affiliate_url' => 'https://example.com/fake-phishing-url',
                'count' => 99,
            ]
        );
    }
}
