<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:1,2'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết',
            'title.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'description.required' => 'Vui lòng nhập nội dung mô tả',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'type.required' => 'Vui lòng chọn loại bài viết',
            'type.in' => 'Loại bài viết không hợp lệ'
        ];
    }
}
