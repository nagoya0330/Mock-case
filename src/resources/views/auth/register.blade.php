@extends('layouts.auth')

@section('content')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="register-container">
    <div class="register-form-wrapper">

        <h1 class="register-title">会員登録</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ユーザー名 --}}
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード --}}
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード確認 --}}
            <div class="form-group">
                <label for="password_confirmation">確認用パスワード</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-wrapper">
                <button type="submit" class="register-button">登録する</button>
            </div>

            <div class="link-wrapper">
                <a href="{{ route('login') }}" class="login-link">ログインはこちら</a>
            </div>
        </form>

    </div>
</div>
@endsection