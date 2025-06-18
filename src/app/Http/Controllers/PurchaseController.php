<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    // 確認画面表示（GET）
    public function confirm($item_id)
    {
        $item = Item::findOrFail($item_id);

        // 🔒 すでに購入済みの場合はトップにリダイレクト
        if ($item->is_sold) {
            return redirect()->route('home')->with('error', 'この商品はすでに購入されています');
        }

        $address = Auth::user()->address;
        $selectedPaymentMethod = session('payment_method');

        return view('items.confirm', compact('item', 'address', 'selectedPaymentMethod'));
    }

    // 支払い方法選択反映（POST）
    public function confirmPost(PurchaseRequest $request, $item_id)
    {
        session()->flash('payment_method', $request->payment_method);
        return redirect()->route('purchase.confirm', ['item_id' => $item_id]);
    }

    // 購入処理（POST）
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // 🔒 すでに購入済みなら処理しない
        if ($item->is_sold) {
            return redirect()->route('home')->with('error', 'この商品はすでに購入されています');
        }

        $user = Auth::user();
        $address = $user->address;

        // 商品を購入済みに更新
        $item->is_sold = true;
        $item->save();

        // 購入情報を保存
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'purchased_at' => now(),
            'shipping_postal_code' => $address->postal_code ?? '',
            'shipping_address' => $address->address ?? '',
            'shipping_building' => $address->building ?? '',
        ]);

        // Stripe仮リンクへリダイレクト
        $stripeTestLink = 'https://buy.stripe.com/test_aFa8wR84V2JWdEb5RabV600';
        return redirect()->away($stripeTestLink);
    }
}