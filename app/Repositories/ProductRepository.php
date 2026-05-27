<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll() {
        return Product::where('is_active', 1)->getAll();
    }

    public function create($data = []) {
        return Product::create($data);
    }
}