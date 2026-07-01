<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index()
    {
        $categories = $this->categoryService->getAll();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request->validated());
        return redirect()->route('categories');
    }

    public function edit($slug)
    {
        $category = $this->categoryService->getBySlug($slug);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $category)
    {
        $this->categoryService->update($category, $request->validated());
        return redirect()->route('categories');
    }

    public function delete($id)
    {
        try {
            $this->categoryService->delete($id);

            alert('Thành công.', 'Xóa danh mục thành công.', 'success');
            return redirect()->back();
        } catch (\Throwable $th) {
            alert('Lỗi.', 'Xóa danh mục thất bại.', 'error');
            return redirect()->back();
        }
    }
}
