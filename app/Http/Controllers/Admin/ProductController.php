<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ImportProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductImageService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ProductImageService $productImageService
    ) {}
    public function index(Request $request)
    {
        $products = $this->productService->getAll($request);
        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        $categories = $this->productService->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function detail($slug)
    {
        $product = $this->productService->findBySlugAdmin($slug);
        return view('admin.products.detail', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return redirect()->route('product-images.create', $product->slug);
    }

    public function edit($slug)
    {
        $categories = $this->productService->getAllCategories();
        $product = $this->productService->findBySlug($slug);
        return view('admin.products.edit', compact('categories', 'product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->update($id, $request->validated());
        alert('Thành công.', 'Cập nhật sản phẩm thành công.', 'success');
        return redirect()->route('admin.products.detail', $product->slug);
    }

    public function updateStatus($id)
    {
        $this->productService->updateStatus($id);

        alert('Thành công.', 'Cập nhật trạng thái thành công.', 'success');
        return redirect()->back();
    }

    public function exportTemplate(ProductTemplateExport $export)
    {
        return $export->download();
    }

    public function import(ImportProductRequest $request)
    {
        try {
            $this->productService->import($request->file('file-import'));

            alert('Thành công.', 'Import thành công.', 'success');
            return redirect()->route('admin.products');
        } catch (ValidationException  $e) {
            // $failures = $e->failures();
            // return redirect()->back()->with('import_errors', $failures);

            alert('Lỗi.', 'Import thất bại.', 'error');
            return redirect()->route('admin.products');
        }
    }

    public function delete($id)
    {
        $this->productService->delete($id);

        alert('Thành công.', 'Xóa sản phẩm thành công.', 'success');
        return redirect()->back();
    }

    public function updateAll(Request $request) {
        $this->productService->massUpdateStatus($request);

        alert('Thành công.', 'Cập nhật trạng thái sản phẩm thành công.', 'success');
        return redirect()->back();
    }
}
