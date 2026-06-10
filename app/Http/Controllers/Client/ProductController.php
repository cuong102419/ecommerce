<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepository $categoryRepository
    ) {}

    public function index(Request $request) {
        $products = $this->productService->getActives($request);
        $categories = $this->categoryRepository->getAll();

        return view("client.products.list", compact('products', 'categories'));
    }

    public function detail($slug) {
        $product = $this->productService->findBySlug($slug);
        $productSuggest = $this->productService->getSuggest();
        return view("client.products.detail", compact('product', 'productSuggest'));
    }
}
