<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll() {
        return Product::all();
    }
}