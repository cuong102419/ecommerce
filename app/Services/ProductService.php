<?php

namespace App\Services;
use App\Imports\ProductsValidationImport;
use App\Jobs\ImportProductsJob;
use App\Repositories\OrderItemRepository;
use App\Repositories\ProductRepository;
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

    public function getAll($request)
    {
        return $this->productRepository->getAll($request);
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

    public function findBySlugAdmin($slug) {
        return $this->productRepository->findBySlugAdmin($slug);
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
        
        return $this->productRepository->updateStatus($product->id, !$product->is_active);
    }

    public function import($file)
    {
        Excel::import(new ProductsValidationImport($this->categoryService), $file);

        $path = $file->store('imports', 'local');
        ImportProductsJob::dispatch($path);
    }

    public function delete($id)
    {
        $product = $this->getById($id);
        if ($product->thumbnail) {
            $isUsed = $this->orderItemRepository->checkByImagePath($product->thumbnail->path);
            if (!$isUsed) {
                Storage::delete($product->thumbnail->path);
            }
        }

        return $this->productRepository->delete($product->id);
    }

    public function massUpdateStatus($request) {
        if ($request['action'] == 'delete') {
            foreach($request['id-product'] as $id) {
                $this->delete($id);
            }

            return true;
        }

        $status = $request['action'] == 'active' ? true : false;
        return $this->productRepository->massUpdateStatus($request['id-product'], $status);
    }
}
