<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function create(array $data) {
        return OrderItem::create($data);
    }

    public function checkByImagePath($imagePath) {
        return OrderItem::where('product_image', $imagePath)->exists();
    }

    public function getByOrderId($orderId) {
        return OrderItem::where('order_id', $orderId)->get();
    }
}
