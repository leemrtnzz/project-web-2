<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo Creator',
            'username' => 'demo',
            'email' => 'demo@example.com',
            'bio' => 'Rekomendasi produk pilihan yang bikin hidup makin gampang. Semua link affiliate, harga bisa berubah kapan aja ya!',
            'email_verified_at' => now(),
        ]);

        $categories = collect(['Gadget', 'Kecantikan', 'Rumah Tangga'])
            ->mapWithKeys(fn (string $name) => [
                $name => $user->categories()->create(['name' => $name]),
            ]);

        collect([
            ['Gadget', 'TWS Bluetooth Pro', 'tws'],
            ['Gadget', 'Mechanical Keyboard 65%', 'keyboard'],
            ['Gadget', 'Powerbank 20.000mAh', 'powerbank'],
            ['Kecantikan', 'Sunscreen SPF 50 PA++++', 'sunscreen'],
            ['Kecantikan', 'Serum Niacinamide 10%', 'serum'],
            ['Rumah Tangga', 'Air Fryer 5L', 'airfryer'],
            ['Rumah Tangga', 'Lampu Meja Minimalis', 'lampu'],
        ])->each(function (array $product) use ($user, $categories) {
            [$category, $title, $seed] = $product;

            $user->affiliateProducts()->create([
                'category_id' => $categories[$category]->id,
                'title' => $title,
                'image' => "https://picsum.photos/seed/{$seed}/600/600",
                'affiliate_url' => "https://example.com/aff/{$seed}",
            ]);
        });
    }
}
