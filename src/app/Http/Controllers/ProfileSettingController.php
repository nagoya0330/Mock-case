<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Address;

class ProfileSettingController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $address = $user->address;

        return view('profile.setting', compact('user', 'address'));
    }

    public function store(ProfileRequest $request)
    {
    $user = Auth::user();

    // プロフィール画像の処理
    if ($request->hasFile('profile_image')) {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $path;
    }

    // 入力内容を上書き（name など）
    $user->fill($request->validated());
    $user->save();

    // 住所情報を更新
    $user->address()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'postal_code' => $request->input('postal'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
        ]
    );

    // 初回プロフィール登録判定
    if (session()->pull('is_first_profile', false)) {
        return redirect()->route('home')->with('message', 'プロフィールを登録しました');
    }

    return redirect()->route('profile.show')->with('message', 'プロフィールを更新しました');
    }
}
