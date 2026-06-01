<?php

namespace App\Repositories;

use App\Models\ProductImage;

class ProductImageRepository
{
    /**
     * Create a new class instance.
     */
    public function create(array $data)
    {
        return ProductImage::create($data);
    }

    public function update($productId, array $data)
    {
        return ProductImage::where("product_id", $productId)->update($data);
    }

    public function getByProductId($productId) {
        return ProductImage::where("product_id", $productId)->first();
    }
}
