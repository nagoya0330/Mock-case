@extends('layouts.main')

@section('title', 'プロフィール画面')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="profile-header">
        <div class="profile-avatar">
            @if ($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="profile-image">
            @else
                <div class="no-image">NO IMAGE</div>
            @endif
        </div>
        <div class="profile-info">
            <h2 class="username">{{ $user->name }}</h2>
            <a href="{{ route('profile.setting') }}" class="edit-button">プロフィールを編集</a>
        </div>
    </div>

    <div class="tabs">
        <a href="{{ url('/mypage?page=sell') }}" class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ url('/mypage?page=buy') }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <div class="product-list">
        @forelse ($items as $item)
            <div class="product-card">
                <div class="product-image">
                    @if ($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像" style="width: 100%; height: auto;">
                    @else
                        <div class="no-image">画像なし</div>
                    @endif
                </div>
                <div class="product-name">{{ $item->name }}</div>
            </div>
        @empty
            <p>{{ $page === 'buy' ? '購入した商品はありません。' : '出品された商品はありません。' }}</p>
        @endforelse
    </div>
</div>
@endsection
