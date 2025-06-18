<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証ユーザーなので許可
    }

    public function rules()
    {
        return [
            'payment_method' => 'required|in:コンビニ払い,カード支払い',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();

            if (!$user || !$user->address || !$user->address->postal_code || !$user->address->address) {
                $validator->errors()->add('address', '配送先住所が未登録です。プロフィール設定から住所を登録してください。');
            }
        });
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in' => '支払い方法は「コンビニ払い」または「カード支払い」のいずれかを選んでください。',
        ];
    }
}