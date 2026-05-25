<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function index() {
        return view('admin.categories.index');
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request) {
        $this->categoryRepository->create($request->all());
        return redirect()->route('categories');
    }
}
