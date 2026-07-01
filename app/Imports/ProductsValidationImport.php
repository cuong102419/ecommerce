<?php

namespace App\Imports;

use App\Services\CategoryService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ProductsValidationImport implements ToModel, WithHeadingRow, WithValidation, WithMultipleSheets
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
        HeadingRowFormatter::default('none');
    }

    public function sheets(): array
    {
        return ['Sản phẩm' => $this];
    }

    public function model(array $row)
    {
        return null;
    }

    public function rules(): array
    {
        return [
            'category_name' => 'required|exists:categories,name',
            'name'          => 'required|string',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:1',
            'description'   => 'nullable',
        ];
    }
}
