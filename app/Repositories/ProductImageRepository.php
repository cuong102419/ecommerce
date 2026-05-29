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
}
