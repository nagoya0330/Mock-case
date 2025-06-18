<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    /**
     * 商品一覧表示（おすすめ or マイリスト）
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 'recommend'); // ← 修正: page に統一
        $keyword = $request->query('search'); // 検索キーワード

        if ($page === 'mylist') {
            // マイリスト表示（ログインユーザーの「いいね」）
            if (Auth::check()) {
                $query = Auth::user()->favorites();

                // 検索がある場合、商品名でフィルタ
                if (!empty($keyword)) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }

                $items = $query->latest()->get();
            } else {
                $items = collect(); // 未ログイン時は空
            }
        } else {
            // おすすめ商品表示（ログインユーザーの出品商品を除外）
            $query = Item::query();

            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }

            if (!empty($keyword)) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }

            $items = $query->latest()->get();
        }

        return view('index', compact('items', 'page', 'keyword')); // ← page を渡す
    }

    /**
     * 商品詳細ページ表示（いいね数・コメント数も取得）
     */
    public function show($item_id)
    {
        $item = Item::with(['categories', 'favoritedBy', 'comments.user'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }

    /**
     * プロフィールに紐づく商品一覧表示
     */
    public function showProfile()
    {
        $user = Auth::user();
        $items = $user->items;
        return view('mypage.profile.profile', compact('user', 'items'));
    }

    /**
     * 出品画面表示
     */
    public function create()
    {
        $categories = Category::all();
        return view('items.sell', compact('categories'));
    }

    /**
     * 商品保存処理
     */
    public function store(ExhibitionRequest $request)
    {
        // 画像アップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public'); // 保存先ディレクトリ指定（items）
        }

        // 商品登録
        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $request->input('name');
        $item->brand_name = $request->input('brand_name');
        $item->description = $request->input('description');
        $item->condition = $request->input('condition');
        $item->price = $request->input('price');
        $item->image_path = $imagePath;
        $item->save();

        // カテゴリを中間テーブルに保存
        $item->categories()->attach($request->input('categories'));

        return redirect()->route('home')->with('message', '商品を出品しました');
    }
}