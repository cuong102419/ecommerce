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
}
