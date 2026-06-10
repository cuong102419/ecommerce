<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    public function create(array $data) {
        return $this->categoryRepository->create($data);
    }

    public function update($id, array $data) {
        return $this->categoryRepository->update($id, $data);
    }

    public function getBySlug($slug) {
        return $this->categoryRepository->getBySlug($slug);
    }

    public function getAll() {
        return $this->categoryRepository->getAll();
    }

    public function getByName($name) {
        return $this->categoryRepository->getByName($name);
    }

    public function delete($id) {
        return $this->categoryRepository->delete($id);
    }
}
