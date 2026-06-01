<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository {
    public function getAll() {
        return Category::latest()->paginate(10);
    }

    public function getBySlug($slug) {
        return Category::where('slug', $slug)->first();
    }

    public function getByName($name) {
        return Category::where('name', $name)->first();
    }

    public function create($data = []) {
        return Category::create($data);
    }

    public function update($id, $data = []) {
        $category = Category::find($id);
        return $category->update($data);
    }

    public function delete($id) {
        return Category::destroy($id);
    }
}