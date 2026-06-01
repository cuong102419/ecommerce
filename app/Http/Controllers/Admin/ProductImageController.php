<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImage\StoreProductImageRequest;
use App\Http\Requests\ProductImage\UpdateProductImageRequest;
use App\Services\ProductImageService;
use App\Services\ProductService;

class ProductImageController extends Controller
{
    public function __construct(
        protected ProductService $productService, 
        protected ProductImageService $productImageService
    ) {}

    public function create($slug)
    {
        $product = $this->productService->findBySlug($slug);
        return view('admin.product-images.create', compact('product'));
    }

    public function store(StoreProductImageRequest $request) {
        $this->productImageService->create($request->validated());

        return redirect()->route('admin.products');
    }

    public function update(UpdateProductImageRequest $request, $productId) {
        $product = $this->productService->getById($productId);
        $this->productImageService->update($productId, $request->validated());
        
        return redirect()->route('admin.products.detail', $product->slug);
    }
}
