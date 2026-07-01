<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class HomeController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}
    
    public function index() {
        $products = $this->productService->getHomePage();
        return view("client.home.index", compact("products"));
    }
}
