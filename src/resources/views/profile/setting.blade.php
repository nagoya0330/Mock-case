@extends('layouts.main')

@section('title', 'プロフィール設定')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile-setup.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-form-wrapper">

        <h1 class="profile-title">プロフィール設定</h1>

        <form method="POST" action="{{ route('profile.setting.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="profile-photo-section">
                <div class="photo-frame">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="profile-image">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                </div>
                <label for="profile_image" class="photo-button">画像を選択する</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display: none;">
            </div>

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="postal">郵便番号</label>
                <input type="text" id="postal" name="postal" value="{{ old('postal', optional($address)->postal_code) }}">
                @error('postal')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" id="address" name="address" value="{{ old('address', optional($address)->address) }}">
                @error('address')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" value="{{ old('building', optional($address)->building) }}">
                @error('building')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="button-wrapper">
                <button type="submit" class="update-button">更新する</button>
            </div>
        </form>

    </div>
</div>
@endsection