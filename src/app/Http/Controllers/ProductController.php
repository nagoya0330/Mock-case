<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;

class ProductController extends Controller
{
    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        // 画像を保存（ある場合）
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // 商品を保存
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'brand_name' => $validated['brand_name'] ?? null,
            'description' => $validated['description'],
            'condition' => $validated['condition'],
            'price' => $validated['price'],
            'image_path' => $imagePath,
            'is_recommended' => false,
        ]);

        // カテゴリを中間テーブルに保存
        $item->categories()->sync($validated['categories']);

        return redirect()->route('home')->with('success', '商品を出品しました');
    }
}
