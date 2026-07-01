<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name'
        ];
    }

        public function messages(): array {
        return [
            'name.required'=> 'Tên không được để trống.',
            'name.string' => 'Tên không hợp lệ.',
            'name.max' => 'Tối đa 255 kí tự.',
            'name.unique' => 'Tên đã tồn tại, hãy chọn tên khác.'
        ];
    }
}
