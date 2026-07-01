<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $products = [
            [
                'category_id' => $categories['Bánh mỳ'],
                'name'        => 'Bánh mỳ bơ tỏi',
                'description' => 'Bánh mỳ thơm giòn với bơ tỏi đặc biệt',
                'price'       => 25000,
                'stock'       => 100,
                'is_active'   => true,
            ],
            [
                'category_id' => $categories['Bánh sinh nhật'],
                'name'        => 'Bánh sinh nhật dâu tây',
                'description' => 'Bánh kem dâu tây tươi ngon',
                'price'       => 350000,
                'stock'       => 20,
                'is_active'   => true,
            ],
            [
                'category_id' => $categories['Bánh quy'],
                'name'        => 'Bánh quy bơ',
                'description' => 'Bánh quy bơ giòn tan',
                'price'       => 85000,
                'stock'       => 200,
                'is_active'   => true,
            ],
            [
                'category_id' => $categories['Bánh ngọt'],
                'name'        => 'Bánh su kem',
                'description' => 'Bánh su kem nhân vanilla mềm mịn',
                'price'       => 15000,
                'stock'       => 50,
                'is_active'   => true,
            ],
            [
                'category_id' => $categories['Chocolate'],
                'name'        => 'Bánh chocolate đen',
                'description' => 'Bánh chocolate đen đậm vị',
                'price'       => 120000,
                'stock'       => 30,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
