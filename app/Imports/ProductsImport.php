<?php

namespace App\Imports;

use App\Models\Product;
use App\Services\CategoryService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithMultipleSheets
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
        HeadingRowFormatter::default('none');
    }

    public function sheets(): array {
        return [
            'Sản phẩm' => $this
        ];
    }

    public function model(array $row)
    {
        $category = $this->categoryService->getByName($row['category_name']);

        $existingProduct = Product::where('name', $row['name'])->first();

        if($existingProduct) {
            $existingProduct->increment('stock', $row['stock']);
            return null;
        }

        return new Product([
            'category_id' => $category->id,
            'name' => $row['name'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'description' => $row['description'] ?? null,
            'is_active' => 0
        ]);
    }

    public function rules(): array
    {
        return [];
    }
}
