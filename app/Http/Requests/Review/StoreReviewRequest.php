<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Vui lòng không để trống.', 
            'rating.min' => 'Giá trị thấp nhất là 1 sao.', 
            'rating.max' => 'Giá trị cao nhất là 5 sao.'
        ];
    }
}
