<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository {
    public function getAll() {
        return Category::all();
    }

    public function create($data = []) {
        return Category::create($data);
    }

    public function update($id, $data = []) {
        return Category::update($id, $data);
    }

    public function delete($id) {
        return Category::destroy($id);
    }
}