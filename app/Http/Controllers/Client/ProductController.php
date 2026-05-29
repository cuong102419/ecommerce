<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index() {
        $products = $this->productService->getAll();
        return view("client.products.list", compact("products"));
    }

    public function detail($slug) {
        $product = $this->productService->findBySlug($slug);
        $productSuggest = $this->productService->getSuggest();
        return view("client.products.detail", compact('product', 'productSuggest'));
    }
}
