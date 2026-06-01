<?php

namespace App\Services;

use App\Imports\ProductsImport;
use App\Repositories\ProductRepository;
use Maatwebsite\Excel\Facades\Excel;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryService $categoryService
    ) {}

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    public function getById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function getActives()
    {
        return $this->productRepository->getActives();
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
}
