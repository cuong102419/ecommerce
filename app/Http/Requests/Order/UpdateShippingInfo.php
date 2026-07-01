<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingInfo extends FormRequest
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
            'email' => 'required|email',
            'shipping_name' => 'required',
            'shipping_phone' => 'required',
            'shipping_address' => 'required',
            'note' => 'nullable',
        ];
    }

     public function messages(): array {
        return [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ.',
            'shipping_name.required' => 'Tên không được để trống.',
            'shipping_phone.required' => 'Số điện thoại không được để trống.',
            'shipping_address.required' => 'Địa chỉ không được để trống.',
        ];
    }
}
