<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    // 住所変更画面を表示
    public function edit($item_id)
    {
        return view('edit-address', ['item_id' => $item_id]);
    }

    // 住所情報の保存処理
    public function update(AddressRequest $request, $item_id)
    {
        $user = Auth::user();

        // 住所を更新または新規作成
        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->input('postal'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]
        );

        return redirect()->route('purchase.confirm', ['item_id' => $item_id])
                        ->with('message', '住所を更新しました');
    }
}