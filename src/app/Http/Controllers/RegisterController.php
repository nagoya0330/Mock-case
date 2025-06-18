<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    // 会員登録画面を表示
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 会員登録処理を追加
    public function register(RegisterRequest $request)
    {
        // バリデーション済データを取得
        $validated = $request->validated();

        // ユーザー登録
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 認証済みにする場合（ログイン処理）
        auth()->login($user);


        session(['is_first_profile' => true]); // 初回設定フラグを付与

        return redirect()->route('profile.setting');

    }
}
