<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll() {
        return Product::latest()->paginate(6);
    }

    public function findBySlug($slug) {
        return Product::where('slug', $slug)->first();
    }

    public function findByName($name) {
        return Product::where('name', $name)->first();
    }

    public function getSuggest() {
        return Product::latest()->paginate(3);
    }

    public function create($data = []) {
        return Product::create($data);
    }

    public function update($id, $data = []) {
        $product = Product::find($id);
        return $product->update($data);
    }
}