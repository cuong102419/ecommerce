<?php

namespace App\Services;

use App\Imports\ProductsImport;
use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryService $categoryService,
        protected OrderItemRepository $orderItemRepository
    ) {}

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function getById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function getActives($request)
    {
        $data = $request;
        if (!empty($data['category']) && $data['category'] != 'all') {
            $category = $this->categoryService->getBySlug($request['category']);
            $data['category'] = $category->id;
        } else {
            $data['category'] = null;
        }

        return $this->productRepository->getActives($data);
    }

    public function getHomePage()
    {
        return $this->productRepository->getHomePage();
    }

    public function getSuggest()
    {
        return $this->productRepository->getSuggest();
    }

    public function getAllCategories()
    {
        return $this->categoryService->getAll();
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function findBySlug($slug)
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function findByName($name)
    {
        return $this->productRepository->findByName($name);
    }

    public function update($id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function updateStatus($id)
    {
        $product = $this->getById($id);
        $product->update([
            'is_active' => !$product->is_active
        ]);

        return redirect()->back();
    }

    public function import($file)
    {
        try {
            Excel::import(new ProductsImport($this->categoryService), $file);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function delete($id) {
        $product = $this->getById($id);
        $isUsed = $this->orderItemRepository->checkByImagePath($product->thumbnail->path);
        if (!$isUsed) {
            Storage::delete($product->thumbnail->path);
        }

        return $this->productRepository->delete($product->id);
    }
}
