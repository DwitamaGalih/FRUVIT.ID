<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FruvitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@fruvit.id'],
            [
                'name' => 'Admin FRUVIT.ID',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Categories
        $categories = [
            [
                'name' => 'Salad Buah',
                'slug' => 'salad-buah',
                'icon' => '🥗',
                'description' => 'Salad buah segar dengan saus dressing creamy melimpah keju premium.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Susu Jelly',
                'slug' => 'susu-jelly',
                'icon' => '🥤',
                'description' => 'Minuman susu creamy segar dipadu topping jelly buah kenyal manis.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Buah Potong',
                'slug' => 'buah-potong',
                'icon' => '🍉',
                'description' => 'Buah potong dingin segar berkualitas tinggi, higienis & praktis siap santap.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Paket Hemat',
                'slug' => 'paket-hemat',
                'icon' => '✨',
                'description' => 'Paket komplit lebih hemat untuk santap bersama atau camilan kenyang.',
                'sort_order' => 4,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['slug']] = Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Create Products
        $products = [
            [
                'category_id' => $categoryModels['salad-buah']->id,
                'name' => 'Salad Buah Creamy Cheese',
                'slug' => 'salad-buah-creamy-cheese',
                'description' => 'Potongan buah segar pilihan (apel, melon, semangka, buah naga/anggur) dipadukan dressing creamy spesial manis gurih dengan topping parutan keju melimpah.',
                'price' => 13000,
                'image' => 'images/products/salad-buah.jpg',
                'badge' => 'Best Seller',
                'is_available' => true,
                'stock' => 100,
                'sort_order' => 1,
            ],
            [
                'category_id' => $categoryModels['susu-jelly']->id,
                'name' => 'Susu Jelly Mangga',
                'slug' => 'susu-jelly-mangga',
                'description' => 'Minuman susu segar rasa buah tropis dipadukan dengan kenyalnya jelly mangga manis lembut yang menyegarkan dahaga.',
                'price' => 12500,
                'image' => 'images/products/susu-jelly-mangga.jpg',
                'badge' => 'Favorit',
                'is_available' => true,
                'stock' => 80,
                'sort_order' => 2,
            ],
            [
                'category_id' => $categoryModels['susu-jelly']->id,
                'name' => 'Susu Jelly Pisang',
                'slug' => 'susu-jelly-pisang',
                'description' => 'Perpaduan susu creamy manis aroma pisang khas ala banana milk Korea dengan sensasi jelly lembut yang nagih.',
                'price' => 12500,
                'image' => 'images/products/susu-jelly-pisang.jpg',
                'badge' => 'Recommended',
                'is_available' => true,
                'stock' => 75,
                'sort_order' => 3,
            ],
            [
                'category_id' => $categoryModels['susu-jelly']->id,
                'name' => 'Susu Jelly Melon',
                'slug' => 'susu-jelly-melon',
                'description' => 'Sensasi susu melon hijau segar dingin dengan potongan jelly melon kenyal dan lembut di setiap sedotan.',
                'price' => 12500,
                'image' => 'images/products/susu-jelly-melon.jpg',
                'badge' => 'Segar',
                'is_available' => true,
                'stock' => 75,
                'sort_order' => 4,
            ],
            [
                'category_id' => $categoryModels['buah-potong']->id,
                'name' => 'Buah Potong Semangka Segar',
                'slug' => 'buah-potong-semangka-segar',
                'description' => 'Semangka merah segar potong dadu tanpa biji yang manis, juicy, dingin, dan dikemas rapi higienis dalam box transparan.',
                'price' => 10000,
                'image' => 'images/products/buah-potong-semangka.jpg',
                'badge' => 'Best Seller',
                'is_available' => true,
                'stock' => 60,
                'sort_order' => 5,
            ],
            [
                'category_id' => $categoryModels['buah-potong']->id,
                'name' => 'Buah Potong Melon Manis',
                'slug' => 'buah-potong-melon-manis',
                'description' => 'Melon hijau pilihan dengan tekstur renyah, rasa manis alami, dan disajikan dingin menyegarkan dalam kemasan box higienis.',
                'price' => 10000,
                'image' => 'images/products/buah-potong-melon.jpg',
                'badge' => 'Manis Alami',
                'is_available' => true,
                'stock' => 60,
                'sort_order' => 6,
            ],
            [
                'category_id' => $categoryModels['paket-hemat']->id,
                'name' => 'Paket Combo Fruvit Lengkap',
                'slug' => 'paket-combo-fruvit-lengkap',
                'description' => 'Dapatkan 1 Porsi Salad Buah Cheese + 1 Box Buah Potong (Semangka/Melon) + 1 Cup Susu Jelly (Varian Bebas). Lebih komplit dan hemat!',
                'price' => 32000,
                'image' => 'images/banner-promo.jpg',
                'badge' => 'Hemat Rp 3.500',
                'is_available' => true,
                'stock' => 50,
                'sort_order' => 7,
            ],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(['slug' => $prod['slug']], $prod);
        }

        // 4. Default Settings
        $settings = [
            'store_name' => 'FRUVIT.ID',
            'store_tagline' => 'Segar Buahnya, Nikmat Rasanya',
            'store_status' => 'open', // 'open' or 'closed'
            'wa_admin' => '081234567890',
            'store_address' => 'Stand Kewirausahaan FRUVIT.ID (Area Kampus / Food Court)',
            'delivery_fee' => '5000',
            'qris_image' => 'images/qris-fruvit.jpg',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }
    }
}
