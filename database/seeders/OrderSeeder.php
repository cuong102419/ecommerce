<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        for ($i = 0; $i < 100; $i++) {

            $createdAt = fake()->dateTimeBetween(
                '-18 months',
                now()
            );

            $order = Order::create([
                'user_id'          => $users->random()->id,
                'status'           => fake()->randomElement([
                    'pending',
                    'paid',
                    'processing',
                    'shipped',
                    'delivered',
                    'delivered',
                    'delivered',
                    'delivered',
                    'delivered',
                    'cancelled',
                ]),
                'payment_method'   => fake()->randomElement([
                    'cod',
                    'momo',
                    'vnpay',
                ]),
                'email'            => fake()->safeEmail(),
                'shipping_name'    => fake()->name(),
                'shipping_phone'   => fake()->numerify('09########'),
                'shipping_address' => fake()->address(),
                'note'             => fake()->optional()->sentence(),
                'total_amount'     => 0,
                'created_at'       => $createdAt,
                'updated_at'       => $createdAt,
            ]);

            $totalAmount = 0;

            $selectedProducts = $products->random(rand(1, 4));

            foreach ($selectedProducts as $product) {

                $quantity = rand(1, 5);

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'quantity'      => $quantity,
                    'product_name'  => $product->name,
                    'product_image' => $product->image,
                    'unit_price'    => $product->price,
                    'created_at'    => $createdAt,
                    'updated_at'    => $createdAt,
                ]);

                $totalAmount += $product->price * $quantity;
            }

            $totalAmount += 50000;

            $order->update([
                'total_amount' => $totalAmount,
            ]);
        }
    }
}
