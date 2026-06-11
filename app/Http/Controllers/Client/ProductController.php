<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryRepository $categoryRepository,
        protected OrderRepository $orderRepository,
        protected ReviewRepository $reviewRepository
    ) {}

    public function index(Request $request) {
        $products = $this->productService->getActives($request);
        $categories = $this->categoryRepository->getAll();

        return view("client.products.list", compact('products', 'categories'));
    }

    public function detail($slug) {
        $product = $this->productService->findBySlug($slug);
        $productSuggest = $this->productService->getSuggest();
        $reviews = $this->reviewRepository->list($product->id);
        if (Auth::check()) {
            $hasBought = $this->orderRepository->hasBought(Auth::id(), $product->id);
            $hasReviewed = $this->reviewRepository->hasReviewed(Auth::id(), $product->id);
        }

        return view("client.products.detail", compact('product', 'productSuggest', 'reviews', 'hasBought', 'hasReviewed'));
    }
}
