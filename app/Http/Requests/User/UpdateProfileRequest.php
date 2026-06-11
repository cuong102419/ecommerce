<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string',
            'old_password' => 'required|current_password',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên không hợp lệ.',
            'old_password.required' => 'Mật khẩu cũ không được để trống.',
            'old_password.current_password' => 'Mật khẩu cũ không chính xác.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu không hợp lệ.',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
            'password.confirmed' => 'Mật khẩu không khớp.'
        ];
    }
}
