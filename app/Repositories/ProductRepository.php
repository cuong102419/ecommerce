<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll()
    {
        return Product::latest()->paginate(6);
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function getActives()
    {
        return Product::where('is_active', true)->latest()->paginate(10);
    }
    
    public function getHomePage() {
        return Product::where('is_active', true)->limit(6)->get();
    }

    public function findBySlug($slug)
    {
        return Product::where('slug', $slug)->first();
    }

    public function findByName($name)
    {
        return Product::where('name', $name)->first();
    }

    public function getSuggest()
    {
        return Product::latest()->paginate(3);
    }

    public function create($data = [])
    {
        return Product::create($data);
    }

    public function update($id, $data = [])
    {
        $product = Product::find($id);
        $product->update($data);
        return $product;
    }
}
