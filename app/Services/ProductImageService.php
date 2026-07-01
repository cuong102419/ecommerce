<?php

namespace App\Services;

use App\Repositories\ProductImageRepository;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductImageRepository $productImageRepository,
        protected ProductService $productService,
        protected OrderItemService $orderItemService
    ) {}

    public function create(array $data)
    {
        if (isset($data['path'])) {
            $data['path'] = $data['path']->store('products', 'public');
        }
        return $this->productImageRepository->create($data);
    }

    public function update($productId, array $data)
    {
        $product = $this->productService->getById($productId);
        $image = $this->productImageRepository->getByProductId($productId);

        if ($image) {
            $isUsed = $this->orderItemService->checkImagePath($image->path);

            if (!$isUsed) {
                Storage::delete($image->path);
            }
        }

        if (isset($data['path'])) {
            $data['path'] = $data['path']->store('products', 'public');
        }

        $this->productImageRepository->update($productId, $data);

        return $product;
    }
}
