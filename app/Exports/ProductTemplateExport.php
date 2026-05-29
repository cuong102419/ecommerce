<?php

namespace App\Exports;

use App\Services\CategoryService;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductTemplateExport
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function download() {
        $spreadsheet = new Spreadsheet();

        $productSheet = $spreadsheet->getActiveSheet();
        $productSheet->setTitle('Sản phẩm');

        $headers = ['category_name', 'name', 'price', 'stock', 'description'];
        foreach ($headers as $index => $header) {
            $col = chr(65 + $index);
            $productSheet->setCellValue($col . '1', $header);
            $productSheet->getStyle($col . '1')->getFont()->setBold(true);
        }

        $productSheet->setCellValue('B2','Bánh quy bơ');
        $productSheet->setCellValue('C2','15000');
        $productSheet->setCellValue('D2','20');
        $productSheet->setCellValue('E2','Mô tả sản phẩm');

        $catSheet = $spreadsheet->createSheet(1);
        $catSheet->setTitle('Danh mục');
        $catSheet->setCellValue('A1','Tên danh mục');
        $catSheet->getStyle('A1')->getFont()->setBold(true);

        $categories = $this->categoryService->getAll();
        foreach ($categories as $index => $category) {
            $catSheet->setCellValue('A' . ($index + 2), $category->name);
        }

        $lastCatRow = $categories->count() + 1;
        for ($row = 2; $row <= 1000; $row++) {
            $validation = $productSheet->getCell('A' . $row)->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setShowDropDown(false);
            $validation->setFormula1("'Danh mục'!\$A\$2:\$A\${$lastCatRow}");
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="products_template.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
