@extends('layouts.main')

@section('title', '商品詳細')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
<div class="container">
    <!-- 左カラム：画像 -->
    <div class="image-section">
        <div class="product-image">
            @if ($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: auto;">
            @else
                商品画像がありません
            @endif
        </div>
    </div>

    <!-- 右カラム：商品情報 -->
    <div class="info-section">
        <h2 class="product-name">{{ $item->name }}</h2>
        <p class="brand-name">{{ $item->brand_name }}</p>
        <p class="price">¥{{ number_format($item->price) }} <span>(税込)</span></p>

        <div class="icons">
            {{-- いいね --}}
            <div class="icon-box">
                <form method="POST" action="{{ route('favorite.toggle', $item->id) }}" class="favorite-form">
                    @csrf
                    <button type="submit" class="icon-button">
                        @auth
                            @if (auth()->user()->favorites->contains($item->id))
                                ❤️
                            @else
                                ♡
                            @endif
                        @else
                            ♡
                        @endauth
                    </button>
                </form>
                <span>{{ $item->favoritedBy->count() }}</span>
            </div>

            {{-- コメント --}}
            <div class="icon-box">
                <span class="icon-button">💬</span>
                <span>{{ $item->comments->count() }}</span>
            </div>
        </div>

        {{-- 🔒 購入ボタン（未購入時のみ） --}}
        @if (!$item->is_sold)
            <a href="{{ route('purchase.confirm', ['item_id' => $item->id]) }}" class="red-button buy-button">
                購入手続きへ
            </a>
        @else
            <p class="sold-out-label" style="color: red; font-weight: bold;">sold</p>
        @endif

        <div class="description">
            <h3>商品説明</h3>
            <p>{{ $item->description }}</p>
        </div>

        <div class="product-info">
            <h3>商品の情報</h3>
            <p>カテゴリー　
                @if ($item->categories->isNotEmpty())
                    @foreach ($item->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @endforeach
                @else
                    <span class="tag">カテゴリ未設定</span>
                @endif
            </p>
            <p>商品の状態　　
                @switch($item->condition)
                    @case('良好') 良好 @break
                    @case('目立った傷や汚れなし') 目立った傷や汚れなし @break
                    @case('やや傷や汚れあり') やや傷や汚れあり @break
                    @case('状態が悪い') 状態が悪い @break
                    @default {{ $item->condition }}
                @endswitch
            </p>
        </div>

        <div class="comments">
            <h3>コメント({{ $item->comments->count() }})</h3>

            {{-- コメント一覧 --}}
            @foreach($item->comments as $comment)
                <div class="comment">
                    <div class="avatar">
                        @if ($comment->user->profile_image)
                            <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="プロフィール画像" class="comment-avatar">
                        @else
                            <div class="no-avatar">NO IMAGE</div>
                        @endif
                    </div>
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <div class="comment-box">{{ $comment->content }}</div>
                    </div>
                </div>
            @endforeach

            {{-- コメント送信フォーム --}}
            <form class="comment-form" method="POST" action="{{ Auth::check() ? route('comment.store', ['item_id' => $item->id]) : '#' }}">
                @csrf
                <label>商品へのコメント</label><br>

                {{-- 入力は常に可能 --}}
                <textarea name="content">{{ old('content') }}</textarea><br>

                {{-- バリデーションエラー --}}
                @error('content')
                    <p class="comment-error">{{ $message }}</p>
                @enderror

                {{-- 送信ボタン --}}
                <button type="submit" class="red-button" {{ Auth::check() ? '' : 'disabled' }}>
                    コメントを送信する
                </button>

                {{-- 未ログイン時の注意書き --}}
                @guest
                    <p class="comment-warning">※ コメントを投稿するにはログインが必要です。</p>
                @endguest
            </form>
        </div>
    </div>
</div>
@endsection