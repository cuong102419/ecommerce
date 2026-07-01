<?php

namespace App\Http\Requests\ProductImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'product_id' => 'required',
            'path' => 'required|file|image|mimes:jpeg,png,jpg,gif',
            'sort_order' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'path.required' => 'Tệp không được để trống.',
            'path.image' => 'Tệp phải là ảnh.',
            'path.mimes' => 'Tệp phải có định dạng jpge, jpg, png, gif.'
        ];
    }
}
