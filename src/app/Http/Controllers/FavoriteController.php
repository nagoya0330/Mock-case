<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class FavoriteController extends Controller
{
    /**
     * 商品のお気に入りをトグル（追加／削除）する
     */
    public function toggle($itemId)
    {
        $user = Auth::user();
        $item = Item::findOrFail($itemId);

        // すでにお気に入りか確認
        if ($user->favorites()->where('item_id', $item->id)->exists()) {
            // 登録済み → 削除
            $user->favorites()->detach($item->id);
        } else {
            // 未登録 → 登録
            $user->favorites()->attach($item->id);
        }

        return back(); // 元のページにリダイレクト
    }
}