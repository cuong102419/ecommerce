<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }
    public function index() {
        return view('admin.products.index');
    }

    public function create() {
        $categories = $this->categoryRepository->getAll();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request) {
        $product = $this->categoryRepository->create($request->validated());
        return redirect()->back();
    }
}
