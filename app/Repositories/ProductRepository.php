<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll($data)
    {
        $query = Product::query();
        if (!empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }

        if (!empty($data['status'])) {
            $query->where('is_active', $data['status'] == 'active' ? 1 : 0);
        }

        if (!empty($data['quantity'])) {
            match ($data['quantity']) {
                'low-stock'    => $query->where('stock', '<=', 10)->where('stock', '>', 5),
                'almost-stock' => $query->where('stock', '<=', 5)->where('stock', '>', 0),
                'out-of-stock' => $query->where('stock', 0),
                default        => null
            };
        }

        return $query->latest()->paginate(6);
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
            ->where('is_active', true)->when($data['sort'] ?? null, function ($query, $sort) {
                if ($sort === 'price-asc') {
                    $query->orderBy('price', 'asc');
                } elseif ($sort === 'price-desc') {
                    $query->orderBy('price', 'desc');
                }
            }, function ($query) {
                $query->latest();
            })->paginate(9)->withQueryString();
    }

    public function getHomePage()
    {
        return Product::where('is_active', true)->limit(6)->get();
    }

    public function findBySlug($slug)
    {
        return Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function findBySlugAdmin($slug)
    {
        return Product::where('slug', $slug)->firstOrFail();
    }

    public function findByName($name)
    {
        return Product::where('name', $name)->first();
    }

    public function getSuggest()
    {
        return Product::where('is_active', true)->latest()->paginate(3);
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

    public function updateStatus($id, $status)
    {
        $product = $this->getById($id);
        return $product->update(['is_active' => $status]);
    }

    public function massUpdateStatus(array $ids, $status)
    {
        return Product::whereIn('id', $ids)
            ->where('is_active', '!=', $status)
            ->when($status == true, function ($query) {
                $query->whereHas('thumbnail');
            })
            ->update(['is_active' => $status]);
    }
}
