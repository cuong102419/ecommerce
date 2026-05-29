<?php

namespace App\Services;

use App\Repositories\ProductImageRepository;

class ProductImageService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductImageRepository $productImageRepository 
    ) {}

    public function create(array $data) {
        if (isset($data['path'])) {
            $data['path'] = $data['path']->store('products', 'public');
        }
        return $this->productImageRepository->create($data);
    }
}
