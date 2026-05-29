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

    public function findByName($name) {
        return $this->productRepository->findByName($name);
    }

    public function update($product, array $data)
    {
        return $this->productRepository->update($product, $data);
    }

    public function import($file)
    {
        Excel::import(new ProductsImport($this->categoryService), $file);
    }
}
