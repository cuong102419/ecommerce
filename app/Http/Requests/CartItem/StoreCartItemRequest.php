<?php

namespace App\Http\Requests\CartItem;

use App\Repositories\ProductRepository;
use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'session_id' => 'nullable',
            'quantity' => ['required', 'min:1', 'integer', $this->maxStockRule()]
        ];
    }

    public function maxStockRule() {
        $stock = 0;
        if ($this->product_id) {
            $product = $this->productRepository->getById($this->product_id);
            $stock = $product->stock ?? 0;
        }

        return "max:$stock";
    }
}
