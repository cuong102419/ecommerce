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
        return Product::lockForUpdate()->findOrFail($id);
    }

    public function getActives($data)
    {
        return Product::query()->when($data['category'], function ($query, $category_id) {
            $query->where('category_id', $category_id);
        })
        ->when($data['keyword'], function ($query, $keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })
        ->where('is_active', true)->latest()->paginate(9)->withQueryString();
    }

    public function getHomePage()
    {
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
        $product = $this->getById($id);
        $product->update($data);
        return $product;
    }

    public function toggleActive($id, $status)
    {
        $product = $this->getById($id);
        return $product->update(['is_active' => $status]);
    }

    public function decrementStock($id, $quantity)
    {
        $product = $this->getById($id);
        if ($product->stock < $quantity) {
            throw new \RuntimeException("Sản phẩm không đủ số lượng.");
        }
        $product->decrement('stock', $quantity);
        if ($product->stock == 0) {
            return $this->toggleActive($product->id, false);
        }
    }

    public function incrementStock($id, $quantity)
    {
        $product = $this->getById($id);

        return $product->increment('stock', $quantity);
    }

    public function delete($id)
    {
        $product = $this->getById($id);

        return $product->delete();
    }
}
