<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function index() {
        $categories = $this->categoryRepository->getAll();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request) {
        $this->categoryRepository->create($request->validated());
        return redirect()->route('categories');
    }

    public function edit($slug) {
        $category = $this->categoryRepository->getBySlug($slug);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $category) {
        // dd($category);  
        $this->categoryRepository->update($category, $request->validated());
        return redirect()->route('categories');
    }
}
