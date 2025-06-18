<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みユーザーのみ操作可
    }

    public function rules()
    {
    return [
        'postal' => ['required', 'regex:/^\d{3}-\d{4}$/'],
        'address' => 'required|string|max:255',
        'building' => 'required|string|max:255',
    ];
    }

    public function messages()
    {
    return [
        'postal.required' => '郵便番号は必須です。',
        'postal.regex' => '郵便番号はハイフンありの8桁（例: 123-4567）で入力してください。',
        'address.required' => '住所は必須です。',
        'building.required' => '建物名は必須です。',
    ];
    }
}