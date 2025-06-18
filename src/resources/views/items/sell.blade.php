@extends('layouts.main')

@section('title', '商品の出品')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="product-create-container">
    <h2 class="title">商品の出品</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label class="form-label">商品画像</label>
            <div class="image-upload">
                <label for="image" class="upload-box">画像を選択する</label>
                <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- 商品詳細 --}}
        <div class="form-section">
            <label class="form-label">商品の詳細</label>

            {{-- カテゴリ（ボタン風） --}}
            <div class="form-group">
                <label>カテゴリ</label>
                <div class="category-list">
                    @foreach($categories as $category)
                        <input type="checkbox" name="categories[]" id="cat{{ $category->id }}" value="{{ $category->id }}"
                            {{ (collect(old('categories'))->contains($category->id)) ? 'checked' : '' }}>
                        <label for="cat{{ $category->id }}" class="category-tag">{{ $category->name }}</label>
                    @endforeach
                </div>
                @error('categories')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- 商品の状態 --}}
        <div class="form-group">
            <label>商品の状態</label>
            <select name="condition" required>
            <option value="">選択してください</option>
            <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
            <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
            <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        </div>

        {{-- 商品名、ブランド名、説明、価格 --}}
        <div class="form-section">
            <label class="form-label">商品名と説明</label>
            <input type="text" name="name" placeholder="商品名" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="text" name="brand_name" placeholder="ブランド名" value="{{ old('brand_name') }}">
            @error('brand_name')
                <div class="error">{{ $message }}</div>
            @enderror

            <textarea name="description" placeholder="商品の説明">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="text" name="price" placeholder="販売価格（円）" value="{{ old('price') }}">
            @error('price')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>
</div>
@endsection