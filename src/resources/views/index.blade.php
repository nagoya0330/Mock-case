@extends('layouts.main')

@section('title', '商品一覧')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="container">
    <!-- タブ -->
    <div class="tab-menu">
        <a href="{{ url('/' . ($keyword ? '?search=' . urlencode($keyword) : '')) }}"
        class="tab {{ $page === 'recommend' ? 'active' : '' }}">おすすめ</a>

        <a href="{{ url('/?page=mylist' . ($keyword ? '&search=' . urlencode($keyword) : '')) }}"
        class="tab {{ $page === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <hr class="divider">

    <!-- 商品一覧 -->
    <div class="product-grid">
        @foreach ($items as $item)
            <div class="product-box">
                <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                    <div class="image-placeholder">
                        @if ($item->image_path)
                            @if (Str::startsWith($item->image_path, ['http://', 'https://']))
                                <img src="{{ $item->image_path }}" alt="{{ $item->name }}" style="width: 100%; height: auto;">
                            @elseif (Str::startsWith($item->image_path, 'images/'))
                                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: auto;">
                            @else
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 100%; height: auto;">
                            @endif
                        @else
                            商品画像
                        @endif
                    </div>
                </a>

                <div class="item-name">
                    {{ $item->name }}
                    @if ($item->is_sold == 1)
                        <span class="sold-label">Sold</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection