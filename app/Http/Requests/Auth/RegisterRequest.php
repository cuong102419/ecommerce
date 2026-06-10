<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống.',
            'name.string' => 'Tên không chứa kí tự đặc biệt.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được đăng ký.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu không chứa kí tự đặc biệt.',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
            'password.confirmed' => 'Mật khẩu không khớp.'
        ];
    }
}
