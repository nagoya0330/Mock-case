@extends('layouts.main')

@section('title', '住所の変更')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/edit-address.css') }}">
@endsection

@section('content')
<div class="address-wrapper">
    <h1 class="page-title">住所の変更</h1>

    <form action="{{ route('address.update', ['item_id' => $item_id]) }}" method="POST" class="address-form">
        @csrf

        <div class="form-group">
            <label for="postal">郵便番号</label>
            <input type="text" id="postal" name="postal" class="form-input" value="{{ old('postal') }}">
            @error('postal')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" class="form-input" value="{{ old('address') }}">
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" class="form-input" value="{{ old('building') }}">
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="update-button">更新する</button>
    </form>
</div>
@endsection