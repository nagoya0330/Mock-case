@extends('layouts.main')

@section('title', '商品購入画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/item-confirm.css') }}">
@endsection

@section('content')
<div class="purchase-wrapper">

    {{-- 左カラム --}}
    <form method="POST" action="{{ route('purchase.confirm.post', ['item_id' => $item->id]) }}" class="purchase-main">
        @csrf

        <div class="product-info-horizontal">
            <div class="image-box">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                @else
                    <div class="image-placeholder">商品画像</div>
                @endif
            </div>
            <div class="product-text">
                <h2 class="product-name">{{ $item->name }}</h2>
                <p class="product-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <hr class="section-divider">

        {{-- 支払い方法 --}}
        <div class="form-section">
            <h3>支払い方法</h3>
            <select name="payment_method" class="select-box" required onchange="this.form.submit()">
                <option value="">選択してください</option>
                <option value="コンビニ払い" {{ old('payment_method', $selectedPaymentMethod) === 'コンビニ払い' ? 'selected' : '' }}>コンビニ払い</option>
                <option value="カード支払い" {{ old('payment_method', $selectedPaymentMethod) === 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
            </select>

            {{-- 支払い方法のエラー表示 --}}
            @error('payment_method')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <hr class="section-divider">

        {{-- 配送先 --}}
        <div class="form-section">
            <h3>配送先 <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}" class="change-link">変更する</a></h3>

            {{-- ✅ 配送先未設定のエラー表示（この位置に移動） --}}
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror

            @if ($address)
                <p>〒 {{ $address->postal_code }}</p>
                <p>{{ $address->address }} {{ $address->building }}</p>
            @else
                <p>〒 XXX-YYYY</p>
                <p>ここには住所と建物が入ります</p>
            @endif
        </div>
    </form>

    {{-- 右カラム --}}
    <div class="purchase-summary">
        <table>
            <tr><th>商品代金</th><td class="summary-price">¥{{ number_format($item->price) }}</td></tr>
        </table>

        <hr class="summary-divider">

        <table>
            <tr>
                <th>支払い方法</th>
                <td class="summary-method">{{ old('payment_method', $selectedPaymentMethod) ?? '未選択' }}</td>
            </tr>
        </table>

        <form method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
            @csrf
            <input type="hidden" name="payment_method" value="{{ old('payment_method', $selectedPaymentMethod) }}">

            {{-- 支払い方法の再表示（念のため） --}}
            @error('payment_method')
                <p class="error-message">{{ $message }}</p>
            @enderror

            {{-- 配送先の再表示（念のため） --}}
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <button type="submit" class="purchase-button">購入する</button>
        </form>
    </div>
</div>
@endsection