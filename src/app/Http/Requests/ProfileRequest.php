<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // プロフィール画像
            'profile_image' => 'nullable|file|mimes:jpeg,png|max:2048',

            // 名前
            'name' => 'required|string|max:255',

            // 住所関連
            'postal' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'building' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'profile_image.mimes' => 'プロフィール画像はjpegまたはpng形式でアップロードしてください。',
            'profile_image.max' => 'プロフィール画像のサイズは2MB以内でアップロードしてください。',

            'name.required' => 'ユーザー名は必須です。',

            'postal.required' => '郵便番号は必須です。',
            'postal.regex' => '郵便番号はハイフンありの8文字形式（例：123-4567）で入力してください。',

            'address.required' => '住所は必須です。',
            'building.required' => '建物名は必須です。',
        ];
    }
}
