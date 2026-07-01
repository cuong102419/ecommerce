<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    public function list($productId) {
        return Review::where('product_id', $productId)->latest()->paginate(3);
    }

    public function create(array $data) {
        return Review::create($data);
    }

    public function hasReviewed($userId, $productId) {
        return Review::where('user_id', $userId)
        ->where('product_id', $productId)
        ->exists();
    }
}
